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
