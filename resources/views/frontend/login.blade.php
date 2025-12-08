<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Webstore Kencana</title>

  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap"
    rel="stylesheet">
    <!-- fas fa icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

  <!-- Styles / Scripts -->
  @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  @endif
</head>

<body>
  <div class="min-h-screen flex items-center justify-center bg-gray-100 p-4 sm:p-0">
    <div class="flex flex-col sm:flex-row bg-white rounded-xl shadow-2xl overflow-hidden w-full max-w-4xl">

      <div class="hidden sm:flex flex-col justify-center items-center p-8 bg-primary text-white w-1/2">
        <div class="text-center space-y-4">
          <img src="{{ asset('asset/Kencana Store Putih.png') }}" class="w-32 h-auto mx-auto" alt="">
          <h3 class="text-3xl font-extrabold">
            Jelajahi Dunia Belanja
          </h3>
          <p class="">
            Masuk dan temukan ribuan produk terbaik yang kami sediakan khusus untuk Anda.
          </p>
        </div>
      </div>

      <div class="w-full sm:w-1/2 p-8 lg:p-12 space-y-6">
        <h2 class="text-2xl font-bold text-gray-900 text-center sm:text-left">
          Masuk ke Akun Anda
        </h2>

        <form method="POST" action="{{ route('customer.login') }}" class="space-y-6">
          @csrf
          <div>
            <label for="email" class="block text-sm font-medium text-gray-700">
              Email
            </label>
            <input
              id="email"
              name="email"
              type="email"
              required
              class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm transition duration-150"
              placeholder="nama@email.com" />
          </div>

          <div>
            <div class="flex items-center justify-between">
              <label for="password" class="block text-sm font-medium text-gray-700">
                Kata Sandi
              </label>

            </div>
            <input
              id="password"
              name="password"
              type="password"
              required
              class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm transition duration-150"
              placeholder="••••••••" />
          </div>

          <button
            type="submit"
            class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-primary hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150">
            Masuk
          </button>
        </form>

        {{-- === TAMBAHAN LOGIN WITH GOOGLE DI SINI === --}}

        <div class="relative">
          <div class="absolute inset-0 flex items-center" aria-hidden="true">
            <div class="w-full border-t border-gray-300"></div>
          </div>
          <div class="relative flex justify-center text-sm">
            <span class="px-2 bg-white text-gray-500">
              Atau
            </span>
          </div>
        </div>

        <a
          href="{{ route('login.google') }}"
          class="w-full flex justify-center py-2 px-4 border border-gray-300 rounded-md shadow-sm text-base font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 items-center">
         <i class="fab fa-google w-5 mr-3"></i>
          Lanjutkan dengan Google
        </a>

        {{-- === AKHIR TAMBAHAN LOGIN WITH GOOGLE === --}}

        <div class="text-center pt-4">
          <p class="text-sm text-gray-600">
            Belum punya akun?
            <a href="{{ url('register') }}" class="font-bold">
              Daftar Sekarang
            </a>
          </p>
        </div>
      </div>
    </div>
  </div>
</body>

</html>