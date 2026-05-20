<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    // =========================================================
    // SHOW LOGIN FORM
    // =========================================================

    public function showLoginForm()
    {
        return view('auth.login');
    }

    // =========================================================
    // HANDLE LOGIN
    // =========================================================

    public function login(Request $request)
    {
        // VALIDATE INPUT
        $request->validate([
            'email'    => 'required',
            'password' => 'required',
        ], [
            'email.required'    => 'Email atau username wajib diisi.',
            'password.required' => 'Kata sandi wajib diisi.',
        ]);

        $loginInput    = trim($request->email);
        $passwordInput = $request->password;

        // =========================================================
        // STEP 1: CEK DI DATABASE SEKOLAH (admin / guru)
        // =========================================================

        $absensiUser = DB::connection('absensi')
            ->table('user')
            ->where('username', $loginInput)
            ->orWhere('email', $loginInput)
            ->first();

        if ($absensiUser) {
            $stored  = $absensiUser->password;
            $loginOk = false;

            // Cek password hash atau plaintext
            if (!empty($stored) && (str_starts_with($stored, '$2y$') || str_starts_with($stored, '$argon2'))) {
                // Password sudah di-hash bcrypt/argon
                if (password_verify($passwordInput, $stored)) {
                    $loginOk = true;

                    // Rehash jika algoritma sudah usang
                    if (password_needs_rehash($stored, PASSWORD_DEFAULT)) {
                        $newHash = password_hash($passwordInput, PASSWORD_DEFAULT);
                        DB::connection('absensi')
                            ->table('user')
                            ->where('id_user', $absensiUser->id_user)
                            ->update(['password' => $newHash]);
                    }
                }
            } else {
                // Password masih plaintext — migrasi otomatis ke hash
                if ($passwordInput === $stored) {
                    $loginOk = true;

                    $newHash = password_hash($passwordInput, PASSWORD_DEFAULT);
                    DB::connection('absensi')
                        ->table('user')
                        ->where('id_user', $absensiUser->id_user)
                        ->update(['password' => $newHash]);
                }
            }

            if ($loginOk) {
                // Ambil kelas_id dari tabel kelas jika belum ada di user
                $kelasId = $absensiUser->kelas_id ?? null;

                if (empty($kelasId) && !empty($absensiUser->kelas)) {
                    $kelasRow = DB::connection('absensi')
                        ->table('kelas')
                        ->where('nama_kelas', $absensiUser->kelas)
                        ->first();

                    $kelasId = $kelasRow->id_kelas ?? null;
                }

                // Generate token sementara (one-time, expired 2 menit)
                $token = Str::random(64);

                DB::connection('absensi')->table('login_tokens')->insert([
                    'token'      => $token,
                    'user_id'    => $absensiUser->id_user,
                    'username'   => $absensiUser->username,
                    'role'       => $absensiUser->role,
                    'kelas'      => $absensiUser->kelas ?? null,
                    'kelas_id'   => $kelasId,
                    'email'      => $absensiUser->email ?? null,
                    'expires_at' => now()->addMinutes(2),
                ]);

                // Redirect ke bridge plain PHP absensi
                $bridgeUrl = env('ABSENSI_URL') . '/bridge_login.php?token=' . $token;
                return redirect($bridgeUrl);
            }

            // User ketemu di sekolah tapi password salah
            // Jangan lanjut cek ppdb — langsung error
            return back()->withErrors([
                'email' => 'Email/username atau kata sandi salah.',
            ])->withInput();
        }

        // =========================================================
        // STEP 2: CEK DI DATABASE PPDB (orang tua)
        // =========================================================

        $field    = filter_var($loginInput, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        $ppdbUser = User::where($field, $loginInput)->first();

        if (!$ppdbUser || !Hash::check($passwordInput, $ppdbUser->password)) {
            return back()->withErrors([
                'email' => 'Email/username atau kata sandi salah.',
            ])->withInput();
        }

        // Login orang tua via Laravel Auth
        Auth::login($ppdbUser, $request->boolean('remember'));

        return redirect()->route('home');
    }

    // =========================================================
    // LOGOUT
    // =========================================================

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}