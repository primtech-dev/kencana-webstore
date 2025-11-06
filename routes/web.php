<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('frontend.index');
});

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

Route::get('/transaksi', function () {
    return view('frontend.member.transaksi');
});

Route::get('/detail-transaksi/TRX-20251105-001', function () {
    return view('frontend.member.detail-transaksi');
});

Route::get('/daftar-alamat', function () {
    return view('frontend.member.daftar-alamat');
});

Route::get('/wishlist', function () {
    return view('frontend.member.wishlist');
});

Route::get('/point-rewards', function () {
    return view('frontend.member.point-rewards');
});

Route::get('/faq', function () {
    return view('frontend.faq');
});