<?php

namespace App\Http\Controllers;

use App\Mail\OtpMail;
use App\Models\OtpVerification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class RegisterController extends Controller
{
    // =========================================================
    // SHOW REGISTER PAGE
    // =========================================================

    public function showRegister()
    {
        return view('register');
    }

    // =========================================================
    // HANDLE REGISTER → KIRIM OTP
    // =========================================================

    public function register(Request $request)
    {
        // VALIDATE INPUT
        $request->validate([
            'name'     => 'required|string|max:100',
            'username' => 'required|string|max:50|unique:users,username|regex:/^\S+$/',
            'email'    => 'required|email|unique:users,email',
            'phone'    => 'required|string|max:20',
            'password' => 'required|min:8|confirmed',
        ], [
            'name.required'      => 'Nama lengkap wajib diisi.',
            'username.required'  => 'Username wajib diisi.',
            'username.unique'    => 'Username sudah digunakan.',
            'username.regex'     => 'Username tidak boleh mengandung spasi.',
            'email.required'     => 'Email wajib diisi.',
            'email.unique'       => 'Email sudah terdaftar.',
            'phone.required'     => 'No. handphone wajib diisi.',
            'password.required'  => 'Kata sandi wajib diisi.',
            'password.min'       => 'Kata sandi minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
        ]);

        // GENERATE OTP
        $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        // HAPUS OTP LAMA (jika ada)
        OtpVerification::where('email', $request->email)->delete();

        // SIMPAN OTP BARU
        OtpVerification::create([
            'email'      => $request->email,
            'otp'        => $otp,
            'expires_at' => now()->addMinutes(5),
        ]);

        // SIMPAN DATA REGISTRASI DI SESSION
        session([
            'pending_user' => [
                'name'     => $request->name,
                'username' => $request->username,
                'email'    => $request->email,
                'phone'    => $request->phone,
                'password' => Hash::make($request->password),
            ]
        ]);

        // KIRIM OTP VIA EMAIL
        Mail::to($request->email)->send(new OtpMail($otp));

        return redirect()->route('register.otp.form')
            ->with('status', 'Kode OTP telah dikirim ke email kamu.');
    }

    // =========================================================
    // SHOW OTP FORM
    // =========================================================

    public function showOtpForm()
    {
        if (!session('pending_user')) {
            return redirect()->route('register');
        }

        return view('verify-otp-register');
    }

    // =========================================================
    // VERIFY OTP → BUAT AKUN
    // =========================================================

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|digits:6',
        ]);

        $pending = session('pending_user');

        if (!$pending) {
            return redirect()->route('register')
                ->with('error', 'Sesi habis, silakan daftar ulang.');
        }

        $record = OtpVerification::where('email', $pending['email'])
            ->where('otp', $request->otp)
            ->first();

        // OTP SALAH
        if (!$record) {
            return back()->with('error', 'Kode OTP salah.');
        }

        // OTP EXPIRED
        if (now()->isAfter($record->expires_at)) {
            $record->delete();
            return back()->with('error', 'Kode OTP sudah expired. Silakan daftar ulang.');
        }

        // OTP VALID → BUAT USER
        User::create([
            'nama'     => $pending['name'],
            'username' => $pending['username'],
            'email'    => $pending['email'],
            'no_hp'    => $pending['phone'],
            'password' => $pending['password'],
            'role'     => 'orang_tua',
        ]);

        // BERSIHKAN
        $record->delete();
        session()->forget('pending_user');

        return redirect()->route('login')
            ->with('status', 'Akun berhasil dibuat! Silakan login.');
    }

    // =========================================================
    // RESEND OTP
    // =========================================================

    public function resendOtp()
    {
        $pending = session('pending_user');

        if (!$pending) {
            return redirect()->route('register')
                ->with('error', 'Sesi habis, silakan daftar ulang.');
        }

        $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        OtpVerification::where('email', $pending['email'])->delete();

        OtpVerification::create([
            'email'      => $pending['email'],
            'otp'        => $otp,
            'expires_at' => now()->addMinutes(5),
        ]);

        Mail::to($pending['email'])->send(new OtpMail($otp));

        return back()->with('status', 'Kode OTP baru telah dikirim.');
    }
}