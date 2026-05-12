<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('homepage');
})->name('home');

/*
|--------------------------------------------------------------------------
| PPDB
|--------------------------------------------------------------------------
*/

Route::prefix('ppdb')->name('ppdb.')->group(function () {

    Route::get('/', function () {
        return redirect()->route('ppdb.jadwal');
    })->name('index');

    Route::get('/jadwal', function () {
        return view('ppdb.jadwal');
    })->name('jadwal');

    Route::get('/persyaratan', function () {
        return view('ppdb.persyaratan');
    })->name('persyaratan');

    Route::get('/alur', function () {
        return view('ppdb.alur');
    })->name('alur');

    Route::get('/online', function () {
        return view('ppdb.online');
    })->name('online');

    Route::get('/faq', function () {
        return view('ppdb.faq');
    })->name('faq');
});

/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/

Route::view('/login', 'login')->name('login');

Route::view('/register', 'register')->name('register');

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