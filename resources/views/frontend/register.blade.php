<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Webstore Kencana</title>

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap"
        rel="stylesheet">

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
    
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen flex items-center justify-center bg-gray-100 p-4 sm:p-0">
        <div class="flex flex-col sm:flex-row bg-white rounded-xl shadow-2xl overflow-hidden w-full max-w-4xl">

            <div class="hidden sm:flex flex-col justify-center items-center p-8 bg-primary text-white w-1/2">
                <div class="text-center space-y-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-20 w-20 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM5 19a2 2 0 01-2-2v-2a4 4 0 014-4h4a4 4 0 014 4v2a2 2 0 01-2 2H5z" />
                    </svg>
                    
                    <h3 class="text-3xl font-extrabold">
                        Bergabunglah dengan Kami!
                    </h3>
                    <p class="">
                        Daftarkan diri Anda untuk mendapatkan akses penuh ke semua penawaran dan diskon eksklusif.
                    </p>
                </div>
            </div>

            <div class="w-full sm:w-1/2 p-8 lg:p-12 space-y-6">
                <h2 class="text-2xl font-bold text-gray-900 text-center sm:text-left">
                    Buat Akun Baru
                </h2>

                <form method="POST" action="{{ route('customer.register') }}" class="space-y-4">
                    @csrf
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                        <input id="name" name="name" type="text" required 
                            value="{{ old('name') }}" class="mt-1 block w-full px-4 py-2 border rounded-md shadow-sm focus:ring-primary focus:border-primary transition duration-150 
                            @error('name') border-red-500 @else border-gray-300 @enderror" 
                            placeholder="Nama Anda" />
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="email-reg" class="block text-sm font-medium text-gray-700">Email</label>
                        <input id="email-reg" name="email" type="email" required 
                            value="{{ old('email') }}" class="mt-1 block w-full px-4 py-2 border rounded-md shadow-sm focus:ring-primary focus:border-primary transition duration-150 
                            @error('email') border-red-500 @else border-gray-300 @enderror" 
                            placeholder="nama@email.com" />
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="relative">
                        <label for="password-reg" class="block text-sm font-medium text-gray-700">Kata Sandi</label>
                        <input id="password-reg" name="password" type="password" required 
                            class="mt-1 block w-full px-4 py-2 border rounded-md shadow-sm focus:ring-primary focus:border-primary transition duration-150 pr-10 
                            @error('password') border-red-500 @else border-gray-300 @enderror" 
                            placeholder="••••••••" />
                        
                        <span class="absolute inset-y-0 right-0 top-6 flex items-center pr-3 cursor-pointer" onclick="togglePassword('password-reg')">
                            <svg id="toggle-password-reg-icon" class="h-5 w-5 text-gray-400 hover:text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </span>
                        
                        @error('password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="relative">
                        <label for="password-confirm" class="block text-sm font-medium text-gray-700">Konfirmasi Kata Sandi</label>
                        <input id="password-confirm" name="password_confirmation" type="password" required 
                            class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary transition duration-150 pr-10" 
                            placeholder="••••••••" />
                        
                        <span class="absolute inset-y-0 right-0 top-6 flex items-center pr-3 cursor-pointer" onclick="togglePassword('password-confirm')">
                            <svg id="toggle-password-confirm-icon" class="h-5 w-5 text-gray-400 hover:text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </span>
                        
                        </div>

                   <!-- nomor telepon -->
                    <div>
                        <label for="phone-reg" class="block text-sm font-medium text-gray-700">Nomor Telepon</label>
                        <input id="phone-reg" name="phone" type="tel" required 
                            value="{{ old('phone') }}" class="mt-1 block w-full px-4 py-2 border rounded-md shadow-sm focus:ring-primary focus:border-primary transition duration-150 
                            @error('phone') border-red-500 @else border-gray-300 @enderror" 
                            placeholder="0812xxxxxx" />
                        @error('phone')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                   
                        <button
                        type="submit"
                        class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-primary hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition duration-150 transform hover:scale-[1.01]"
                    >
                        Daftar
                    </button>
                </form>

                <div class="text-center pt-4">
                    <p class="text-sm text-gray-600">
                        Sudah punya akun?
                        <a href="{{route('login')}}" class="font-bold text-primary hover:text-green-700">
                            Masuk
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <script>
        function togglePassword(fieldId) {
            const passwordField = document.getElementById(fieldId);
            const toggleIcon = document.getElementById(`toggle-${fieldId}-icon`);

            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                // Ubah ikon ke "mata dicoret/tertutup"
                toggleIcon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 0-8.268-2.943-9.542-7A10.05 10.05 0 0112 5c1.72 0 3.334.464 4.75 1.25M17.25 10.5h-10m4.5-3v6m6-3h-6m6-3v6m-6-6v6m-6-3h6m-6-3v6m6-6v6m-6-3h6m-6-3v6m6-6v6m-6-3h6m-6-3v6M4 4l16 16"/>`;
            } else {
                passwordField.type = 'password';
                // Ubah ikon ke "mata terbuka"
                toggleIcon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />`;
            }
        }
    </script>
</body>
</html>