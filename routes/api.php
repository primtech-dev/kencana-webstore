<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('/register', [App\Http\Controllers\API\AuthController::class, 'register']);
Route::post('/login', [App\Http\Controllers\API\AuthController::class, 'login']);
Route::post('/logout', [App\Http\Controllers\API\AuthController::class, 'logout']);
// Route::get('/login/google/callback', [App\Http\Controllers\API\AuthController::class, 'redirectToGoogle']);
// Route::get('/login/auth/google/callback', [App\Http\Controllers\API\AuthController::class, 'handleGoogleCallback']);
Route::post('/auth/google-verify', [App\Http\Controllers\API\AuthController::class, 'verifyGoogleToken']);


Route::get('/user', function (Request $request) {
    Route::post('/logout', [App\Http\Controllers\API\AuthController::class, 'logout']);

})->middleware('auth:sanctum');
