<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class GoogleLoginController extends Controller
{
    /**
     * Redirect the user to the Google authentication page.
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Handle the callback from Google, performing Sign Up or Sign In.
     */
    public function handleGoogleCallback()
    {
        try {
            // 1. Ambil data pengguna dari Google
            $googleUser = Socialite::driver('google')->user();

            $email = $googleUser->getEmail();
            $googleId = $googleUser->getId();

            // 2. Cek apakah pengguna sudah ada berdasarkan google_id atau email
            $customer = Customer::where('google_id', $googleId)
                        ->orWhere('email', $email)
                        ->first();

            if ($customer) {
                // KASUS 1: SIGN IN (Pengguna Ditemukan)
                
                // Jika ditemukan berdasarkan email tapi belum punya google_id (Sign Up pertama kali dari customer lama)
                if (empty($customer->google_id)) {
                    $customer->google_id = $googleId;
                    $customer->save();
                }

                $message = 'Selamat datang kembali!';

            } else {
                // KASUS 2: SIGN UP (Pengguna Baru)
                
                // Pastikan email belum digunakan oleh akun lain tanpa google_id
                // (Ini sudah dicakup di query pencarian di atas, jadi kita yakin ini user baru)

                // dd($googleId , $email);
                
                $customer = Customer::create([
                    'public_id' => Str::uuid(),
                    'full_name' => $googleUser->getName(),
                    'email' => $email,
                    'google_id' => $googleId,
                    // Tetapkan password random karena field ini wajib di DB
                    'password_hash' => Hash::make(Str::random(16)), 
                    // Pastikan Anda juga mengisi field lain yang mungkin wajib (e.g., email_verified_at)
                    // 'email_verified_at' => now(), 
                ]);
                
                $message = 'Registrasi berhasil! Selamat datang di Kencana Webstore';
            }

            // 3. Log the user in
            Auth::guard('customer')->login($customer);

            // 4. Redirect ke halaman utama
            return redirect('/')->with('success', $message); // Ganti '/home' sesuai kebutuhan

        } catch (\Exception $e) {
            \Log::error('Google login failed: ' . $e->getMessage());
            return redirect('/login')->with('error', 'Google login/signup gagal. Silakan coba lagi.');
        }
    }
}