<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
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

        // CEK APAKAH INPUT EMAIL ATAU USERNAME
        $field = filter_var($request->email, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        // CARI USER
        $user = User::where($field, $request->email)->first();

        // CEK USER & PASSWORD
        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()->withErrors([
                'email' => 'Email/username atau kata sandi salah.',
            ])->withInput();
        }

        // LOGIN
        Auth::login($user, $request->boolean('remember'));

        // REDIRECT BERDASARKAN ROLE
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        return redirect()->route('home');
    }
}