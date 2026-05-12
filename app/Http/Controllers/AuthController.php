<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | SHOW FORGOT PASSWORD
    |--------------------------------------------------------------------------
    */

    public function showForgotPassword()
    {
        return view('forgot-password');
    }

    /*
    |--------------------------------------------------------------------------
    | SEND OTP (DUMMY)
    |--------------------------------------------------------------------------
    */

    public function sendOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        // SIMPAN EMAIL KE SESSION
        session([
            'reset_email' => $request->email
        ]);

        return redirect()
            ->route('verify.otp.page')
            ->with(
                'status',
                'OTP baru berhasil dikirim.'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | SHOW VERIFY OTP PAGE
    |--------------------------------------------------------------------------
    */

    public function showVerifyOtp()
    {
        return view('verify-otp');
    }

    /*
    |--------------------------------------------------------------------------
    | VERIFY OTP (DUMMY)
    |--------------------------------------------------------------------------
    */

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required'
        ]);

        /*
        |--------------------------------------------------------------------------
        | OTP DUMMY
        |--------------------------------------------------------------------------
        |
        | 111111 = SUCCESS
        | 222222 = ERROR ANIMATION
        |
        */

        if ($request->otp === '111111') {

            session([
                'otp_verified' => true
            ]);

            return redirect()->route('reset.password');
        }

        if ($request->otp === '222222') {

            return back()->with(
                'error',
                'Kode OTP salah.'
            );
        }

        return back()->with(
            'error',
            'OTP tidak valid.'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | SHOW RESET PASSWORD PAGE
    |--------------------------------------------------------------------------
    */

    public function showResetPassword()
    {
        if (!session('otp_verified')) {

            return redirect()->route('forgot-password');
        }

        return view('reset-password');
    }

    /*
    |--------------------------------------------------------------------------
    | SAVE NEW PASSWORD (DUMMY)
    |--------------------------------------------------------------------------
    */

    public function resetPassword(Request $request)
    {
        $request->validate([
            'password' => 'required|min:8'
        ]);

        /*
        |----------------------------------------------------------------------
        | DUMMY PASSWORD
        |----------------------------------------------------------------------
        |
        | suki77713 = SUCCESS
        | selain itu = ERROR
        |
        */

        if ($request->password === 'suki77713') {

            // CLEAR SESSION
            session()->forget([
                'reset_email',
                'otp_verified'
            ]);

            return redirect()
                ->route('login')
                ->with(
                    'status',
                    'Password berhasil diubah.'
                );
        }

        return back()->with(
            'error',
            'Password dummy salah.'
        );
    }
}



/* REALLLLLLLL CODE (BELOW)
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

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
        // VALIDATE EMAIL INPUT
        $request->validate([
            'email' => 'required|email'
        ]);

        // CHECK USER EMAIL
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

        // GENERATE RANDOM OTP
        $otp = rand(100000, 999999);

        // SAVE OTP TO DATABASE
        DB::table('password_resets')->updateOrInsert(

            [
                'email' => $request->email
            ],

            [
                'otp' => $otp,
                'created_at' => now(),
                'expired_at' => now()->addMinutes(10)
            ]
        );

        // SEND OTP TO EMAIL
        Mail::raw(

            "Kode OTP reset password anda adalah: $otp",

            function ($message) use ($request) {

                $message->to($request->email)
                        ->subject('Reset Password OTP');
            }
        );

        // SAVE EMAIL TO SESSION
        session([
            'reset_email' => $request->email
        ]);

        // REDIRECT TO VERIFY OTP PAGE
        return redirect()->route('verify.otp.page');
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

        // GET OTP DATA FROM DATABASE
        $reset = DB::table('password_resets')

            ->where('email', $email)

            ->where('otp', $request->otp)

            ->first();

        // OTP NOT FOUND
        if (!$reset) {

            return back()->with(
                'error',
                'Kode OTP salah.'
            );
        }

        // CHECK OTP EXPIRED
        if (now()->gt($reset->expired_at)) {

            return back()->with(
                'error',
                'OTP sudah expired.'
            );
        }

        // SAVE OTP VERIFIED SESSION
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

        // GET USER DATA
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
        $user->password = Hash::make(
            $request->password
        );

        $user->save();

        // DELETE OTP DATA
        DB::table('password_resets')

            ->where('email', $email)

            ->delete();

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
*/