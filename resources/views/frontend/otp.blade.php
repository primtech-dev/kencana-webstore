<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi OTP Webstore Kencana</title>
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
                    <h3 class="text-3xl font-extrabold">Keamanan Akun Anda Prioritas Kami</h3>
                    <p class="">Masukkan kode verifikasi yang telah kami kirimkan melalui WhatsApp untuk melanjutkan.</p>
                </div>
            </div>

            <div class="w-full sm:w-1/2 p-8 lg:p-12 space-y-6">
                <h2 class="text-2xl font-bold text-gray-900 text-center sm:text-left">Verifikasi Akun</h2>
                
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
                    Kami telah mengirimkan kode OTP melalui **WhatsApp** ke **{{ $phone ?? 'Nomor HP Anda' }}**.
                </p>

                <form method="POST" action="{{ route('customer.otp.verify') }}" class="space-y-6">
                    @csrf
                    
                    <div>
                        <label for="otp" class="block text-sm font-medium text-gray-700 mb-2 text-center sm:text-left">
                            Kode OTP (6 Digit)
                        </label>
                        <div class="flex justify-center sm:justify-start space-x-2">
                            <input id="otp" name="otp" type="text" maxlength="6" required autofocus
                                class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm transition duration-150 text-center tracking-widest text-lg"
                                placeholder="******" />
                        </div>
                        
                        {{-- Notifikasi Error Validasi --}}
                        @error('otp')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror

                        <div class="mt-4 text-center sm:text-left">
                            {{-- ID countdown untuk menampilkan sisa waktu --}}
                            <p id="countdown" class="text-sm text-gray-500">Kode akan kedaluwarsa dalam 01:00</p>
                        </div>
                    </div>

                    <button type="submit"
                        class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-primary hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150">
                        Verifikasi
                    </button>
                </form>

                <div class="text-center pt-4">
                    <p class="text-sm text-gray-600">
                        Tidak menerima kode?
                        {{-- Tautan Kirim Ulang (default disabled) --}}
                        <a href="#" id="resend-link" class="font-bold text-gray-400 cursor-not-allowed">Kirim Ulang Kode (Tunggu 60s)</a>
                    </p>
                    <p class="text-sm text-gray-600 mt-2">
                        <a href="{{ route('login') }}" class="font-medium hover:text-gray-900">Kembali ke Halaman Masuk</a>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Waktu awal countdown (60 detik)
            let timeleft = 60; 
            const countdownElement = document.getElementById('countdown');
            const resendLink = document.getElementById('resend-link');

            // Set link kirim ulang dalam kondisi disabled saat mulai
            resendLink.classList.remove('text-primary', 'hover:text-primary-dark', 'cursor-pointer');
            resendLink.classList.add('text-gray-400', 'cursor-not-allowed');
            resendLink.href = "#"; // Menonaktifkan tautan

            const countdownTimer = setInterval(function(){
                if(timeleft <= 0){
                    clearInterval(countdownTimer);
                    countdownElement.innerHTML = "Kode OTP sudah kedaluwarsa. Silakan kirim ulang.";
                    
                    // Aktifkan link kirim ulang
                    resendLink.classList.remove('text-gray-400', 'cursor-not-allowed');
                    resendLink.classList.add('text-primary', 'hover:text-primary-dark', 'cursor-pointer');
                    
                    // Gunakan route ke showOtpForm dengan parameter 'resend'
                    // Ini akan memicu logic di controller Anda untuk mengirim ulang OTP saat user mengklik link ini
                    resendLink.href = "{{ route('customer.otp.show') }}?resend=1"; 
                    resendLink.innerHTML = "Kirim Ulang Kode Sekarang"; 

                } else {
                    const minutes = Math.floor(timeleft / 60);
                    const seconds = timeleft % 60;
                    // Format waktu menjadi MM:SS
                    const formattedTime = `${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;
                    
                    countdownElement.innerHTML = `Kode akan kedaluwarsa dalam ${formattedTime}`;
                    resendLink.innerHTML = `Kirim Ulang Kode (Tunggu ${timeleft}s)`;
                }
                timeleft -= 1;
            }, 1000);
        });
    </script>
</body>
</html>