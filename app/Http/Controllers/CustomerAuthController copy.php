<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\Customer;
use Illuminate\Support\Facades\Http;

class CustomerAuthController extends Controller
{
    function sendWhatsAppNotification($phoneNumber, $message)
    {
        $apiKey = env('WA_API_KEY');
        $apiUrl = env('WA_API_URL');
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
            return $response;
        } catch (\Throwable $th) {
            return $th;
        }
    }
    public function showRegistrationForm()
    {
        return view('frontend.register');
    }

    public function register(Request $request)
    {

      
        $validasi = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:customers,email',
            'phone' => 'nullable|string|max:20',
            'password' => 'required|string',
        ]);     

        $customer = Customer::create([
            'public_id' => Str::uuid(),
            'full_name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password_hash' => Hash::make($request->password),
            'is_active' => true,
        ]);

       

        // Auth::login($customer); 

        return redirect('/')->with('success', 'Pendaftaran berhasil!');
    }

    public function showLoginForm()
    {
        return view('frontend.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $customer = Customer::where('email', $request->email)->first();

        if (!$customer || !Hash::check($request->password, $customer->password_hash)) {
            return back()->withErrors([
                'email' => 'Email atau kata sandi tidak valid.',
            ])->onlyInput('email');
        }

        if (!$customer->is_active) {
            return back()->withErrors([
                'email' => 'Akun Anda belum aktif. Silakan hubungi layanan pelanggan.',
            ])->onlyInput('email');
        }
        
        Auth::guard('customer')->login($customer);

        $request->session()->regenerate();

        return redirect()->intended('/')->with('success', 'Selamat datang kembali!');
    }

    public function logout(Request $request)
    {
        Auth::logout(); 

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Sampai jumpa lagi ya!');
    }

    public function otp()
    {
        return view('frontend.otp');
    }

}