<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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
    // HANDLE REGISTER
    // =========================================================

    public function register(Request $request)
    {
        // VALIDATE INPUT
        $request->validate([
            'name' => 'required|string|max:100',
            'username' => 'required|string|max:50|unique:users,username|regex:/^\S+$/',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string|max:20',
            'password' => 'required|min:8|confirmed',
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'username.required' => 'Username wajib diisi.',
            'username.unique' => 'Username sudah digunakan.',
            'username.regex' => 'Username tidak boleh mengandung spasi. Contoh: nama_pengguna',
            'email.required' => 'Email wajib diisi.',
            'email.unique' => 'Email sudah terdaftar.',
            'phone.required' => 'No. handphone wajib diisi.',
            'password.required' => 'Kata sandi wajib diisi.',
            'password.min' => 'Kata sandi minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
        ]);

        // CREATE USER
        User::create([
            'nama' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'no_hp' => $request->phone,
            'password' => Hash::make($request->password),
            'role' => 'orang_tua',
        ]);

        // REDIRECT TO LOGIN
        return redirect()
            ->route('login')
            ->with('status', 'Akun berhasil dibuat! Silakan login.');
    }
}