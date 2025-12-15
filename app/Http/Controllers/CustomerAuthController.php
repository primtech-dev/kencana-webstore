<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Http; // <-- PASTIKAN INI ADA
use Illuminate\Support\Str;
use App\Models\Customer;
use Throwable; // <-- PASTIKAN INI ADA

class CustomerAuthController extends Controller
{
    // =================================================================
    // FUNGSI PENGIRIMAN WHATSAPP (Diambil dari input Anda)
    // =================================================================
    private function sendWhatsAppNotification($phoneNumber, $message)
    {
        $apiKey = env('WA_API_KEY');
        $apiUrl = env('WA_API_URL');

        // Cek jika variabel environment belum diatur
        if (empty($apiKey) || empty($apiUrl)) {
            // \Log::error("WA_API_KEY atau WA_API_URL belum diatur di .env");
            // Kembalikan objek Response palsu untuk mencegah error, atau lempar exception
            return (object)['successful' => fn() => false, 'body' => 'API Not Configured'];
        }

        try {
            $response = Http::withHeaders([
                'Authorization' => $apiKey,
            ])->post($apiUrl, [
                'recipient_type' => 'individual',
                'to' => $phoneNumber,
                'type' => 'text',
                'text' => [
                    'body' => $message
                ]
            ]);

            // Log respons untuk debugging
            // \Log::info("WA API Response for $phoneNumber: " . $response->body());

            return $response;
        } catch (Throwable $th) { // Menggunakan Throwable untuk menangkap semua error
            // \Log::error("WA Notification failed for $phoneNumber: " . $th->getMessage());
            return $th;
        }
    }
    // -----------------------------------------------------------------


    // --- FUNGSI GENERATE DAN KIRIM OTP UNIFIED ---
    private function generateAndSendOtp($phone, $type)
    {
        $otp = random_int(100000, 999999);
        $message = "Kode Verifikasi ({$type}) Kencana Store Anda adalah: {$otp}. Jangan berikan kode ini kepada siapapun. Kode berlaku 1 menit.";

        $response = $this->sendWhatsAppNotification($phone, $message);

        // Logika error handling jika pengiriman WA gagal
        if (!is_object($response) || (isset($response->status) && $response->status() !== 200)) {
            return false; // Gagal mengirim
        }

        // Simpan OTP di Session
        Session::put('otp.phone', $phone);
        Session::put('otp.code', (string)$otp); // Simpan sebagai string untuk konsistensi
        Session::put('otp.type', $type);
        Session::put('otp.expires_at', now()->addMinutes(1));

        return true; // Berhasil mengirim
    }
    // ---------------------------------------------


    // =================================================================
    // 1. REGISTER FLOW
    // =================================================================

    public function showRegistrationForm()
    {
        return view('frontend.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20|unique:customers,phone',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'phone.unique' => 'Nomor HP ini sudah terdaftar.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
        ]);

        Session::put('customer_registration_data', [
            'full_name' => $request->full_name,
            'phone' => $request->phone,
            'password_hash' => Hash::make($request->password),
        ]);

        if (!$this->generateAndSendOtp($request->phone, 'register')) {
            return back()->with('error', 'Gagal mengirim kode verifikasi WhatsApp. Silakan coba lagi.');
        }

        return redirect()->route('customer.otp.show')->with([
            'success' => 'Kode verifikasi telah dikirimkan ke Nomor HP Anda melalui WhatsApp.',
            'phone' => $request->phone,
        ]);
    }

    // =================================================================
    // 2. LOGIN FLOW
    // =================================================================

    public function showLoginForm()
    {
        return view('frontend.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'phone' => 'required|string|max:20',
            'password' => 'required|string',
        ]);

        $customer = Customer::where('phone', $request->phone)->first();

        if (!$customer || !Hash::check($request->password, $customer->password_hash)) {
            return back()->withErrors(['phone' => 'Nomor HP atau kata sandi tidak valid.'])->onlyInput('phone');
        }

        // Kirim OTP untuk verifikasi login
        if (!$this->generateAndSendOtp($request->phone, 'login')) {
            return back()->with('error', 'Gagal mengirim kode verifikasi WhatsApp. Silakan coba lagi.');
        }

        Session::put('customer_login_id', $customer->id);

        return redirect()->route('customer.otp.show')->with([
            'success' => 'Kode verifikasi untuk login telah dikirimkan ke Nomor HP Anda melalui WhatsApp.',
            'phone' => $request->phone,
        ]);
    }

    // =================================================================
    // 3. LUPA PASSWORD FLOW
    // =================================================================

    public function showForgotPasswordForm()
    {
        return view('frontend.lupa-password');
    }

    public function forgotPassword(Request $request)
    {
        $request->validate([
            'phone' => 'required|string|max:20|exists:customers,phone',
        ], [
            'phone.exists' => 'Nomor HP tidak terdaftar.',
        ]);

        if (!$this->generateAndSendOtp($request->phone, 'reset')) {
            return back()->with('error', 'Gagal mengirim kode verifikasi WhatsApp. Silakan coba lagi.');
        }

        Session::put('reset_password_phone', $request->phone);

        return redirect()->route('customer.otp.show')->with([
            'success' => 'Kode verifikasi untuk reset kata sandi telah dikirimkan ke Nomor HP Anda melalui WhatsApp.',
            'phone' => $request->phone,
        ]);
    }

    // =================================================================
    // OTP VERIFICATION (Handle Logic dan Verifikasi)
    // =================================================================

    public function showOtpForm(Request $request)
    {
        if (!Session::has('otp.phone')) {
            return redirect()->route('login')->with('error', 'Sesi OTP tidak valid. Silakan coba lagi.');
        }

        // Logic untuk menangani Kirim Ulang (Resend OTP)
        if ($request->has('resend') && $request->resend == 1) {
            $phone = Session::get('otp.phone');
            $type = Session::get('otp.type', 'default'); // Ambil jenis flow

            // Panggil fungsi untuk generate dan kirim OTP baru
            if ($this->generateAndSendOtp($phone, $type)) {
                return redirect()->route('customer.otp.show')->with([
                    'success' => 'Kode verifikasi baru telah dikirimkan ke Nomor HP Anda melalui WhatsApp.',
                    'phone' => $phone,
                ]);
            } else {
                return back()->with('error', 'Gagal mengirim ulang kode verifikasi WhatsApp. Silakan coba lagi.');
            }
        }

        return view('frontend.otp', ['phone' => Session::get('otp.phone')]);
    }

    public function verifyOtp(Request $request)
    {
        $request->validate(['otp' => 'required|string|size:6']);

        $sessionOtp = Session::get('otp.code');
        $sessionType = Session::get('otp.type');

        if (!Session::has('otp.expires_at') || now()->gt(Session::get('otp.expires_at'))) {
            Session::forget(['otp.code', 'otp.phone', 'otp.type', 'otp.expires_at']);
            return back()->withErrors(['otp' => 'Kode OTP kedaluwarsa. Silakan kirim ulang.']);
        }

        if ($request->otp !== $sessionOtp) {
            return back()->withErrors(['otp' => 'Kode OTP tidak valid.']);
        }

        // OTP Berhasil diverifikasi, hapus sesi OTP
        $phone = Session::pull('otp.phone');
        Session::forget(['otp.code', 'otp.expires_at', 'otp.type']);

        switch ($sessionType) {
            case 'register':
                return $this->handleRegisterCompletion($phone);
            case 'login':
                return $this->handleLoginCompletion();
            case 'reset':
                return $this->handleResetPasswordStart($phone);
            default:
                return redirect()->route('login')->with('error', 'Verifikasi berhasil, tetapi jenis alur tidak diketahui. Silakan login.');
        }
    }

    // =================================================================
    // OTP COMPLETION HANDLERS
    // =================================================================

    private function handleRegisterCompletion($phone)
    {
        $data = Session::pull('customer_registration_data');
        if (!$data) {
            return redirect()->route('login')->with('error', 'Sesi pendaftaran berakhir.');
        }

        $customer = Customer::create([
            'public_id' => Str::uuid(),
            'full_name' => $data['full_name'],
            'phone' => $data['phone'],
            'password_hash' => $data['password_hash'],
            'is_active' => true,
            // 'is_verified' => true,
        ]);

        Auth::guard('customer')->login($customer);
        return redirect()->intended('/')->with('success', 'Pendaftaran dan verifikasi berhasil! Selamat datang.');
    }

    private function handleLoginCompletion()
    {
        $customerId = Session::pull('customer_login_id');
        if (!$customerId) {
            return redirect()->route('login')->with('error', 'Sesi login berakhir.');
        }

        $customer = Customer::find($customerId);
        if (!$customer) {
            return redirect()->route('login')->with('error', 'Akun tidak ditemukan.');
        }

        Auth::guard('customer')->login($customer);
        Session::regenerate();
        return redirect()->intended('/')->with('success', 'Login berhasil!');
    }

    private function handleResetPasswordStart($phone)
    {
        Session::put('reset_password_phone', $phone);
        Session::put('reset_otp_verified', true);

        return redirect()->route('customer.password.reset.show')->with('phone', $phone);
    }

    // =================================================================
    // RESET PASSWORD
    // =================================================================

    public function showResetPasswordForm(Request $request)
    {
        if (!Session::get('reset_otp_verified') || !Session::has('reset_password_phone')) {
            return redirect()->route('customer.forgot.password.show')->with('error', 'Harap verifikasi Nomor HP Anda terlebih dahulu.');
        }

        return view('frontend.reset-password', ['phone' => Session::get('reset_password_phone')]);
    }

    public function resetPassword(Request $request)
    {
        if (!Session::get('reset_otp_verified') || !Session::has('reset_password_phone')) {
            return redirect()->route('customer.forgot.password.show')->with('error', 'Sesi reset password tidak valid.');
        }

        $request->validate(['password' => 'required|string|min:8|confirmed']);

        $phone = Session::pull('reset_password_phone');
        Session::forget('reset_otp_verified');

        $customer = Customer::where('phone', $phone)->first();

        if (!$customer) {
            return redirect()->route('login')->with('error', 'Akun tidak ditemukan.');
        }

        $customer->password_hash = Hash::make($request->password);
        $customer->save();

        return redirect()->route('login')->with('success', 'Kata sandi berhasil diubah! Silakan login dengan kata sandi baru Anda.');
    }

    // =================================================================
    // LOGOUT
    // =================================================================

    public function logout(Request $request)
    {
        Auth::guard('customer')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/')->with('success', 'Sampai jumpa lagi ya!');
    }
}
