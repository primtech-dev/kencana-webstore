<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'full_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:customers,email',
            'phone' => 'nullable|string|max:20',
            'password' => 'required|string|min:8|confirmed', // 'confirmed' checks for 'password_confirmation' field
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validasi gagal.',
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            $customer = Customer::create([
                'public_id' => Str::uuid(),
                'full_name' => $request->full_name,
                'email' => $request->email,
                'phone' => $request->phone,
                'password_hash' => Hash::make($request->password),
                'is_active' => true, // Sesuaikan dengan logika aktivasi Anda
            ]);


            return response()->json([
                'status' => 'success',
                'message' => 'Pendaftaran berhasil! Silahkan login untuk melanjutkan.',
                'customer' => [
                    'id' => $customer->public_id,
                    'full_name' => $customer->full_name,
                    'email' => $customer->email,
                ],
            ], 201);
        } catch (\Exception $e) {
            Log::error('Customer registration failed: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Pendaftaran gagal. Silakan coba lagi.',
            ], 500);
        }
    }

    /**
     * Handle Customer Login via API.
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validasi gagal.',
                'errors' => $validator->errors(),
            ], 422);
        }

        $customer = Customer::where('email', $request->email)->first();

        if (!$customer || !Hash::check($request->password, $customer->password_hash)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Email atau kata sandi tidak valid.',
            ], 401);
        }

        if (!$customer->is_active) {
            return response()->json([
                'status' => 'error',
                'message' => 'Akun Anda belum aktif. Silakan hubungi layanan pelanggan.',
            ], 403);
        }

        // Hapus token lama untuk keamanan (opsional)
        $customer->tokens()->delete();

        // Buat token Sanctum baru
        $token = $customer->createToken('auth_token')->plainTextToken;

        return response()->json([
            'status' => 'success',
            'message' => 'Selamat datang kembali!',
            'customer' => [
                'id' => $customer->public_id,
                'full_name' => $customer->full_name,
                'email' => $customer->email,
            ],
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }

    /**
     * Handle Customer Logout via API.
     */
    public function logout(Request $request)
    {
        // Hapus token saat ini yang digunakan untuk otentikasi
        // Perlu memastikan bahwa API route ini dilindungi oleh middleware 'auth:sanctum'
        $request->user('customer')->currentAccessToken()->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Logout berhasil. Sampai jumpa lagi!',
        ]);
    }

    // --- Google Socialite API Endpoints ---

    /**
     * Redirect the user to the Google authentication page (Client-side use).
     */
    public function redirectToGoogle()
    {
        $url = Socialite::driver('google')->stateless()->redirect()->getTargetUrl();

        return response()->json([
            'status' => 'success',
            'redirect_url' => $url,
            'message' => 'Redirect ke Google URL.',
        ]);
    }

    /**
     * Handle the callback from Google, performing Sign Up or Sign In (API version).
     */
    public function handleGoogleCallback()
    {
        // Mengambil URL frontend secara eksplisit
        $frontendUrl = env('APP_FE_URL', 'http://localhost:5173') . '/auth/callback';

        try {
            // Menggunakan Socialite untuk API
            $googleUser = Socialite::driver('google')->user();

            $email = $googleUser->getEmail();
            $googleId = $googleUser->getId();

            // Cari atau Buat Pengguna
            $customer = Customer::where('google_id', $googleId)
                ->orWhere('email', $email)
                ->first();
            $message = '';

            if ($customer) {
                // KASUS 1: SIGN IN (Pengguna Ditemukan)
                $message = 'Selamat datang kembali!';

                // Tautkan Google ID jika ditemukan berdasarkan email saja
                if (empty($customer->google_id)) {
                    $customer->google_id = $googleId;
                    $customer->save();
                    $message = 'Akun berhasil ditautkan dengan Google.';
                }
            } else {
                // KASUS 2: SIGN UP (Pengguna Baru)
                $customer = Customer::create([
                    'public_id' => Str::uuid(),
                    // Pastikan getName() tidak mengembalikan null, jika iya, sediakan fallback
                    'full_name' => $googleUser->getName() ?? 'User Google Baru',
                    'email' => $email,
                    'google_id' => $googleId,
                    // Tetapkan password random karena field ini wajib di DB
                    'password_hash' => Hash::make(Str::random(16)),
                    'is_active' => true,
                ]);

                $message = 'Registrasi Google berhasil! Selamat datang di Kencana Webstore';
            }

            // Hapus token lama & buat token Sanctum baru
            $customer->tokens()->delete();
            $token = $customer->createToken('auth_token')->plainTextToken;

            // PENGALIHAN AKHIR KE FRONTEND DENGAN TOKEN
            return redirect()->to($frontendUrl . '?token=' . $token . '&status=success&message=' . urlencode($message));
        } catch (\Exception $e) {

            // =========================================================
            // BLOK CATCH UNTUK DIAGNOSIS ERROR (PENTING)
            // =========================================================

            // Siapkan data konteks untuk logging
            $logContext = [
                'exception_trace' => $e->getTraceAsString(),
                'error_message' => $e->getMessage()
            ];

            // Coba ambil respons body Guzzle (tempat error code 400/invalid_grant berada)
            if (method_exists($e, 'getResponse') && $e->getResponse()) {
                $logContext['response_body'] = (string) $e->getResponse()->getBody();
            }

            // Log error secara detail
            Log::error('Google login failed (Diagnosis Required): ', $logContext);

            // Tentukan pesan error yang dikirim ke Frontend
            $errorMessage = 'Otentikasi Gagal. Cek log server untuk detail.';

            if (isset($logContext['response_body'])) {
                // Jika ada body respons Guzzle, ambil bagian yang relevan (misalnya 'redirect_uri_mismatch')
                $errorJson = json_decode($logContext['response_body'], true);
                if (isset($errorJson['error']) && isset($errorJson['error_description'])) {
                    $errorMessage = $errorJson['error_description'];
                } else {
                    $errorMessage = 'Gagal menukar kode. Cek URL Redirect di Google Console.';
                }
            } elseif ($e->getMessage() !== '') {
                $errorMessage = $e->getMessage();
            }

            // Redirect ke frontend dengan status error
            return redirect()->to($frontendUrl . '?status=error&message=' . urlencode('Otentikasi Gagal: ' . $errorMessage));
        }
    }


    public function verifyGoogleToken(Request $request)
    {
        $idToken = $request->input('id_token');

        if (!$idToken) {
            return response()->json(['message' => 'Token tidak disediakan.'], 401);
        }

        try {
            // 1. Inisialisasi Google Client untuk verifikasi
            $client = new Client(['client_id' => env('GOOGLE_CLIENT_ID')]);
            
            // 2. VERIFIKASI ID TOKEN
            // Ini akan memverifikasi tanda tangan, issuer, dan audiens (client ID)
            $payload = $client->verifyIdToken($idToken);

            if (!$payload) {
                return response()->json(['message' => 'Token otentikasi tidak valid.'], 401);
            }
            
            // Ambil data user dari payload (klaim JWT)
            $googleId = $payload['sub']; // Subject (Google User ID)
            $email = $payload['email'];
            $name = $payload['name'] ?? null;

            // 3. SINKRONISASI DATABASE LOKAL (Login atau Register)
            $customer = Customer::where('google_id', $googleId)
                                ->orWhere('email', $email)
                                ->first();
            
            if (!$customer) {
                // Sign Up: Pengguna baru
                $customer = Customer::create([
                    'public_id' => Str::uuid(),
                    'full_name' => $name ?? 'User Google',
                    'email' => $email,
                    'google_id' => $googleId, 
                    'password_hash' => Hash::make(Str::random(16)), 
                    'is_active' => true,
                ]);
            }
            // Jika sudah ada, langsung Sign In.

            // 4. BUAT TOKEN SANCTUM
            $customer->tokens()->delete();
            $sanctumToken = $customer->createToken('auth_token')->plainTextToken;

            return response()->json([
                'status' => 'success',
                'token' => $sanctumToken,
                'user' => [
                    'email' => $customer->email,
                    'full_name' => $customer->full_name,
                ],
            ]);

        } catch (\Exception $e) {
            Log::error("Google Token Verification Error: " . $e->getMessage());
            return response()->json(['message' => 'Token verifikasi gagal: ' . $e->getMessage()], 500);
        }
    }
}
