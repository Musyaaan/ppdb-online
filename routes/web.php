<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;

Route::get('/', function () {
    return view('homepage');
})->name('home');

/*
|--------------------------------------------------------------------------
| PPDB
|--------------------------------------------------------------------------
*/

Route::get('/ppdb', function () {
    return view('ppdb');
})->name('ppdb');

/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/

/* LOGIN */
Route::get('/login', function () {
    return view('login');
})->name('login');
Route::post('/login', [LoginController::class, 'login']);

/* REGISTER */
Route::get('/register', [RegisterController::class, 'showRegister'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

Route::get('/register/verify-otp', [RegisterController::class, 'showOtpForm'])->name('register.otp.form');
Route::post('/register/verify-otp', [RegisterController::class, 'verifyOtp'])->name('register.otp.verify');
Route::post('/register/resend-otp', [RegisterController::class, 'resendOtp'])->name('register.resend-otp');

/*
|--------------------------------------------------------------------------
| FORGOT PASSWORD OTP
|--------------------------------------------------------------------------
*/

/* FORM EMAIL */
Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])
    ->name('forgot-password');

/* KIRIM OTP */
Route::post('/forgot-password', [AuthController::class, 'sendOtp'])
    ->name('forgot-password.send');

/* PAGE OTP */
Route::get('/verify-otp', [AuthController::class, 'showVerifyOtp'])
    ->name('verify.otp.page');

/* VERIFY OTP */
Route::post('/verify-otp', [AuthController::class, 'verifyOtp'])
    ->name('verify.otp');

/* PAGE RESET PASSWORD */
Route::get('/reset-password', [AuthController::class, 'showResetPassword'])
    ->name('reset.password');

/* SAVE NEW PASSWORD */
Route::post('/reset-password', [AuthController::class, 'resetPassword'])
    ->name('reset.password.post');

Route::get('/galeri', function () {
    return view('galeri');
})->name('galeri');

Route::get('/kontak', function () {
    return view('kontak');
})->name('kontak');