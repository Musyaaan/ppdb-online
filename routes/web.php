<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FormulirController;
use App\Http\Controllers\DokumenController;
use App\Http\Controllers\CetakBuktiController;
use App\Http\Controllers\ProfilController;

/* ─────────────────────────────────────────────
   PUBLIC PAGES
───────────────────────────────────────────── */
Route::get('/', fn() => view('homepage'))->name('home');
Route::get('/ppdb', fn() => view('ppdb'))->name('ppdb');
Route::get('/galeri', fn() => view('galeri'))->name('galeri');
Route::get('/kontak', fn() => view('kontak'))->name('kontak');

/* ─────────────────────────────────────────────
   AUTH
───────────────────────────────────────────── */
Route::get('/login', fn() => view('login'))->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [RegisterController::class, 'showRegister'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register.post');
Route::get('/register/verify-otp', [RegisterController::class, 'showOtpForm'])->name('register.otp.form');
Route::post('/register/verify-otp', [RegisterController::class, 'verifyOtp'])->name('register.otp.verify');
Route::post('/register/resend-otp', [RegisterController::class, 'resendOtp'])->name('register.resend-otp');

/* ─────────────────────────────────────────────
   FORGOT PASSWORD
───────────────────────────────────────────── */
Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('forgot-password');
Route::post('/forgot-password', [AuthController::class, 'sendOtp'])->name('forgot-password.send');
Route::get('/verify-otp', [AuthController::class, 'showVerifyOtp'])->name('verify.otp.page');
Route::post('/verify-otp', [AuthController::class, 'verifyOtp'])->name('verify.otp');
Route::get('/reset-password', [AuthController::class, 'showResetPassword'])->name('reset.password');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('reset.password.post');

/* ─────────────────────────────────────────────
   AUTHENTICATED ROUTES
───────────────────────────────────────────── */
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
   Route::get('/cetak-bukti',          [CetakBuktiController::class, 'index'])->name('cetak.index');
   Route::get('/cetak-bukti/print',    [CetakBuktiController::class, 'printOnly'])->name('cetak.print');
   Route::get('/cetak-bukti/download', [CetakBuktiController::class, 'download'])->name('cetak.download');

    /* STATUS PENDAFTARAN */
    Route::get('/status', [StatusController::class, 'index'])->name('status.index');

    /* PROFIL */
    Route::get('/profil', [ProfilController::class, 'index'])->name('profil');
    Route::put('/profil/update', [ProfilController::class, 'update'])->name('profil.update');
    Route::put('/profil/password', [ProfilController::class, 'gantiPassword'])->name('profil.password');
});