<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk dengan OTP - Webstore Kencana</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>
<body>
    <div class="min-h-screen flex items-center justify-center bg-gray-100 p-4 sm:p-0">
        <div class="flex flex-col sm:flex-row bg-white rounded-xl shadow-2xl overflow-hidden w-full max-w-4xl">

            {{-- Sisi Kiri: Branding --}}
            <div class="hidden sm:flex flex-col justify-center items-center p-8 bg-primary text-white w-1/2">
                <div class="text-center space-y-4">
                    <img src="{{ asset('asset/Kencana Store Putih.png') }}" class="w-32 h-auto mx-auto" alt="Logo Kencana Store">
                    <h3 class="text-3xl font-extrabold">Akses Cepat & Aman</h3>
                    <p class="">Masuk ke akun Anda tanpa ribet menghafal kata sandi. Cukup verifikasi nomor HP Anda.</p>
                </div>
            </div>

            {{-- Sisi Kanan: Form --}}
            <div class="w-full sm:w-1/2 p-8 lg:p-12 space-y-6">
                <h2 class="text-2xl font-bold text-gray-900 text-center sm:text-left">Masuk dengan OTP</h2>
                
                {{-- AREA NOTIFIKASI --}}
                @if(session('success'))
                    <div class="p-3 text-sm text-green-700 bg-green-100 rounded-lg" role="alert">
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="p-3 text-sm text-red-700 bg-red-100 rounded-lg" role="alert">
                        {{ session('error') }}
                    </div>
                @endif

                <p class="text-sm text-gray-600 text-center sm:text-left">
                    Metode ini sangat disarankan bagi **pelanggan lama** atau jika Anda sedang tidak ingin menggunakan kata sandi.
                </p>

                <form method="POST" action="{{ route('customer.login.otp.send') }}" class="space-y-6">
                    @csrf
                    
                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700">Nomor HP Terdaftar</label>
                        <input id="phone" name="phone" type="tel" required autofocus value="{{ old('phone') }}"
                            class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm transition duration-150"
                            placeholder="Contoh: 08123456789" />
                            
                        @error('phone')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <button type="submit"
                        class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-primary hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150">
                        Kirim Kode OTP melalui WhatsApp
                    </button>
                </form>

                <div class="text-center pt-4 border-t border-gray-100">
                    <p class="text-sm text-gray-600">
                        Ingat kata sandi Anda? 
                        <a href="{{ route('login') }}" class="font-bold text-primary hover:text-primary-dark">
                            Masuk secara normal
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>