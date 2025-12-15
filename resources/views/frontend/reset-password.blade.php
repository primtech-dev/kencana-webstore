<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Kata Sandi Baru Webstore Kencana</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>
<body>
    <div class="min-h-screen flex items-center justify-center bg-gray-100 p-4 sm:p-0">
        <div class="flex flex-col sm:flex-row bg-white rounded-xl shadow-2xl overflow-hidden w-full max-w-4xl">

            <div class="hidden sm:flex flex-col justify-center items-center p-8 bg-primary text-white w-1/2">
                <div class="text-center space-y-4">
                    <img src="{{ asset('asset/Kencana Store Putih.png') }}" class="w-32 h-auto mx-auto" alt="Logo Kencana Store">
                    <h3 class="text-3xl font-extrabold">Berhasil! Kata Sandi Baru Anda Siap</h3>
                    <p class="">Mohon masukkan kata sandi baru yang kuat dan mudah diingat.</p>
                </div>
            </div>

            <div class="w-full sm:w-1/2 p-8 lg:p-12 space-y-6">
                <h2 class="text-2xl font-bold text-gray-900 text-center sm:text-left">Atur Ulang Kata Sandi</h2>
                
                {{-- AREA NOTIFIKASI SUKSES DAN GAGAL UMUM --}}
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
                {{-- END AREA NOTIFIKASI --}}

                <p class="text-sm text-gray-600 text-center sm:text-left">
                    Verifikasi Nomor HP berhasil. Silakan masukkan kata sandi baru Anda.
                </p>

                <form method="POST" action="{{ route('customer.password.reset') }}" class="space-y-6">
                    @csrf
                    
                    <div>
                        <label for="display_phone" class="block text-sm font-medium text-gray-700">Nomor HP Anda</label>
                        <input id="display_phone" type="text"
                            class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm bg-gray-50 sm:text-sm"
                            value="{{ $phone ?? 'Nomor HP tidak ditemukan' }}"
                            readonly />
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700">Kata Sandi Baru</label>
                        <input id="password" name="password" type="password" required autofocus
                            class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm transition duration-150"
                            placeholder="••••••••" />
                            
                        {{-- Notifikasi Error Validasi --}}
                        @error('password')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>
                    
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Konfirmasi Kata Sandi Baru</label>
                        <input id="password_confirmation" name="password_confirmation" type="password" required
                            class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm transition duration-150"
                            placeholder="••••••••" />
                    </div>

                    <button type="submit"
                        class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-primary hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150">
                        Atur Ulang Kata Sandi
                    </button>
                </form>

                <div class="text-center pt-4">
                    <p class="text-sm text-gray-600">
                        <a href="{{ route('customer.login.show') }}" class="font-bold hover:text-gray-900 flex items-center justify-center">
                            <i class="fas fa-sign-in-alt mr-2"></i> Kembali ke Halaman Masuk
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>