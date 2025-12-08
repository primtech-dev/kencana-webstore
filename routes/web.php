<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CustomerAuthController;
use App\Http\Controllers\GoogleLoginController;
use App\Http\Controllers\HistoryTransactionController;
use App\Http\Controllers\MemberAddressController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\ProductController;

// Route::get('/', function () {
//     return view('frontend.index');
// });

Route::get('/detail-produk', function () {
    return view('frontend.detail');
});

Route::get('/keranjang', function () {
    return view('frontend.keranjang');
});

Route::get('/checkout', function () {
    return view('frontend.checkout');
});

Route::get('/promo', function () {
    return view('frontend.promo');
});

Route::get('/profile', function () {
    return view('frontend.member.profile');
});

Route::get('/transaksi-member', function () {
    return view('frontend.member.transaksi');
});

Route::get('/detail-transaksi/TRX-20251105-001', function () {
    return view('frontend.member.detail-transaksi');
});

// Route::get('/daftar-alamat', function () {
//     return view('frontend.member.daftar-alamat');
// });

Route::get('/wishlist', function () {
    return view('frontend.member.wishlist');
});

Route::get('/point-rewards', function () {
    return view('frontend.member.point-rewards');
});

Route::get('/faq', function () {
    return view('frontend.faq');
});



Route::get('/register', [CustomerAuthController::class, 'showRegistrationForm'])->name('customer.register.form');
Route::post('/register', [CustomerAuthController::class, 'register'])->name('customer.register');

Route::get('/login', [CustomerAuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [CustomerAuthController::class, 'login'])->name('customer.login');

Route::post('/logout', [CustomerAuthController::class, 'logout'])->name('customer.logout');

Route::get('login/google/callback', [GoogleLoginController::class, 'redirectToGoogle'])->name('login.google');
Route::get('login/auth/google/callback', [GoogleLoginController::class, 'handleGoogleCallback']);


// Rute untuk menampilkan daftar produk
Route::get('/', [ProductController::class, 'index'])->name('products.index');

// Rute untuk menampilkan detail produk
Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');

// customer dashboard
// routes/web.php

Route::middleware(['auth:customer'])->group(function () {
    Route::get('/dashboard', function () {
        // Akses pengguna yang sedang login
        $customer = auth('customer')->user();
        return view('customer.dashboard');
    })->name('customer.dashboard');

    Route::group(['prefix' => 'member'], function () {
        Route::get('/', [MemberController::class, 'index'])->name('member.index');
        // Route::get('/profile', [MemberController::class, 'profile'])->name('member.profile');
        Route::post('/update-profile', [MemberController::class, 'updateProfile'])->name('member.update-profile');
        Route::get('/daftar-alamat', [MemberAddressController::class, 'index'])->name('member.addresses.index');
        Route::post('/daftar-alamat', [MemberAddressController::class, 'store'])->name('member.addresses.store');
        Route::put('/daftar-alamat/{address}', [MemberAddressController::class, 'update'])->name('member.addresses.update');

        // Route untuk Jadikan Utama
        Route::put('/daftar-alamat/{address}/default', [MemberAddressController::class, 'setAsDefault'])->name('member.addresses.default');

        // Route untuk Hapus (Destroy)
        Route::delete('/daftar-alamat/{address}', [MemberAddressController::class, 'destroy'])->name('member.addresses.destroy');

        
        // Route::get('/transaksi-member', [MemberController::class, 'index'])->name('member.transactions');
        Route::get('/transaksi-member/{id}', [MemberController::class, 'showTransaction'])->name('member.transactions.show');
    });

    Route::group(['prefix' => 'keranjang'], function () {
        Route::get('/', [CartController::class, 'index'])->name('cart.index');
        Route::post('/add', [CartController::class, 'addToCart'])->name('cart.add');
        Route::delete('/hapus/{itemId}', [CartController::class, 'destroy'])->name('cart.destroy');
        Route::post('/update', [CartController::class, 'updateCart'])->name('cart.update');
        Route::post('/update-quantity/{itemId}', [CartController::class, 'updateQuantity'])
            ->name('cart.update-quantity');
    });

    Route::group(['prefix' => 'checkout'], function () {
        Route::post('/', [CheckoutController::class, 'index'])->name('checkout.index');
        Route::get('/now', [CheckoutController::class, 'buyNow'])->name('checkout.now');
        Route::post('/process', [CheckoutController::class, 'store'])->name('checkout.store');
    });

    Route::group(['prefix' => 'history-transactions'], function () {
        Route::get('/', [HistoryTransactionController::class, 'index'])->name('history.transactions.index');
        Route::get('/{order_no}', [HistoryTransactionController::class, 'show'])->name('history.transactions.show');
    });
});
