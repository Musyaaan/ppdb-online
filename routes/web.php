<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FormulirController;
use App\Http\Controllers\DokumenController;
use App\Http\Controllers\CetakBuktiController;

Route::get('/', function () {
    return view('homepage');
})->name('home');

Route::get('/ppdb', function () {
    return view('ppdb');
})->name('ppdb');

Route::get('/galeri', function () {
    return view('galeri');
})->name('galeri');

Route::get('/kontak', function () {
    return view('kontak');
})->name('kontak');

/* LOGIN */
Route::get('/login', function () {
    return view('login');
})->name('login');
Route::post('/login', [LoginController::class, 'login']);

/* LOGOUT */
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

/* REGISTER */
Route::get('/register', [RegisterController::class, 'showRegister'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);
Route::get('/register/verify-otp', [RegisterController::class, 'showOtpForm'])->name('register.otp.form');
Route::post('/register/verify-otp', [RegisterController::class, 'verifyOtp'])->name('register.otp.verify');
Route::post('/register/resend-otp', [RegisterController::class, 'resendOtp'])->name('register.resend-otp');

/* FORGOT PASSWORD */
Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('forgot-password');
Route::post('/forgot-password', [AuthController::class, 'sendOtp'])->name('forgot-password.send');
Route::get('/verify-otp', [AuthController::class, 'showVerifyOtp'])->name('verify.otp.page');
Route::post('/verify-otp', [AuthController::class, 'verifyOtp'])->name('verify.otp');
Route::get('/reset-password', [AuthController::class, 'showResetPassword'])->name('reset.password');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('reset.password.post');

/* DASHBOARD & PPDB (AUTH REQUIRED) */
Route::middleware(['auth'])->group(function () {

    /* DASHBOARD */
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.orangtua');

    /* FORMULIR PENDAFTARAN */
    Route::get('/formulir', [FormulirController::class, 'index'])->name('formulir.index');
    Route::post('/formulir/step1', [FormulirController::class, 'saveStep1'])->name('formulir.step1');
    Route::post('/formulir/step2', [FormulirController::class, 'saveStep2'])->name('formulir.step2');
    Route::post('/formulir/step3', [FormulirController::class, 'saveStep3'])->name('formulir.step3');
    Route::post('/formulir/submit', [FormulirController::class, 'submit'])->name('formulir.submit');

    /* UPLOAD DOKUMEN */
    Route::get('/dokumen', [DokumenController::class, 'index'])->name('dokumen.index');
    Route::post('/dokumen/upload', [DokumenController::class, 'upload'])->name('dokumen.upload');
    Route::delete('/dokumen/{id}', [DokumenController::class, 'destroy'])->name('dokumen.destroy');

    /* CETAK BUKTI */
    Route::get('/cetak-bukti', [CetakBuktiController::class, 'index'])->name('cetak.index');
    Route::get('/cetak-bukti/download', [CetakBuktiController::class, 'download'])->name('cetak.download');

});