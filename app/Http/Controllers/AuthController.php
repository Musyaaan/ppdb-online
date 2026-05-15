<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Mail\OtpMail;

class AuthController extends Controller
{
    // =========================================================
    // SHOW FORGOT PASSWORD PAGE
    // =========================================================

    public function showForgotPassword()
    {
        return view('forgot-password');
    }

    // =========================================================
    // SEND OTP TO EMAIL
    // =========================================================

    public function sendOtp(Request $request)
    {
        // VALIDATE EMAIL
        $request->validate([
            'email' => 'required|email'
        ]);

        // CEK USER
        $user = User::where(
            'email',
            $request->email
        )->first();

        // EMAIL NOT FOUND
        if (!$user) {

            return back()->with(
                'error',
                'Email tidak ditemukan.'
            );
        }

        // GENERATE OTP
        $otp = rand(100000, 999999);

        // SIMPAN OTP KE TABEL USERS
        $user->otp            = $otp;
        $user->otp_expired_at = now()->addMinutes(5);
        $user->save();

        // KIRIM EMAIL
        Mail::to($request->email)->send(new OtpMail($otp));

        // SIMPAN EMAIL KE SESSION
        session([
            'reset_email' => $request->email
        ]);

        // REDIRECT TO VERIFY OTP PAGE
        return redirect()
            ->route('verify.otp.page')
            ->with(
                'status',
                'OTP berhasil dikirim ke email anda.'
            );
    }

    // =========================================================
    // SHOW VERIFY OTP PAGE
    // =========================================================

    public function showVerifyOtp()
    {
        return view('verify-otp');
    }

    // =========================================================
    // VERIFY OTP
    // =========================================================

    public function verifyOtp(Request $request)
    {
        // VALIDATE OTP
        $request->validate([
            'otp' => 'required'
        ]);

        // GET EMAIL FROM SESSION
        $email = session('reset_email');

        // CEK OTP DI TABEL USERS
        $user = User::where('email', $email)
            ->where('otp', $request->otp)
            ->first();

        // OTP SALAH
        if (!$user) {

            return back()->with(
                'error',
                'Kode OTP salah.'
            );
        }

        // CEK EXPIRED
        if (now()->gt($user->otp_expired_at)) {

            return back()->with(
                'error',
                'OTP sudah expired.'
            );
        }

        // SAVE SESSION
        session([
            'otp_verified' => true
        ]);

        // REDIRECT TO RESET PASSWORD PAGE
        return redirect()->route('reset.password');
    }

    // =========================================================
    // SHOW RESET PASSWORD PAGE
    // =========================================================

    public function showResetPassword()
    {
        // BLOCK DIRECT ACCESS
        if (!session('otp_verified')) {

            return redirect()->route('forgot-password');
        }

        return view('reset-password');
    }

    // =========================================================
    // SAVE NEW PASSWORD
    // =========================================================

    public function resetPassword(Request $request)
    {
        // VALIDATE PASSWORD
        $request->validate([
            'password' => [
                'required',
                'min:8',
                'confirmed'
            ]
        ]);

        // GET EMAIL SESSION
        $email = session('reset_email');

        // GET USER
        $user = User::where(
            'email',
            $email
        )->first();

        // USER NOT FOUND
        if (!$user) {

            return redirect()
                ->route('forgot-password')
                ->with(
                    'error',
                    'User tidak ditemukan.'
                );
        }

        // UPDATE PASSWORD
        $user->password = Hash::make($request->password);

        // CLEAR OTP
        $user->otp            = null;
        $user->otp_expired_at = null;

        $user->save();

        // CLEAR SESSION
        session()->forget([
            'reset_email',
            'otp_verified'
        ]);

        // REDIRECT TO LOGIN PAGE
        return redirect()
            ->route('login')
            ->with(
                'status',
                'Password berhasil diubah.'
            );
    }
}