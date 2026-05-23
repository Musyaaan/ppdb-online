<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfilController extends Controller
{
    public function index()
    {
        return view('dashboard.profil');
    }

    public function update(Request $request)
    {
        $request->validate([
            'nama'     => 'required|string|max:100',
            'username' => 'required|string|max:50|unique:users,username,' . Auth::id() . ',id_user',
            'email'    => 'required|email|unique:users,email,' . Auth::id() . ',id_user',
            'no_hp'    => 'nullable|string|max:20',
        ]);

        Auth::user()->update($request->only('nama', 'username', 'email', 'no_hp'));

        return back()->with('success', 'Data profil berhasil diperbarui.');
    }

    public function gantiPassword(Request $request)
    {
        $request->validate([
            'password_lama' => 'required',
            'password_baru' => 'required|min:8|confirmed',
        ]);

        if (!Hash::check($request->password_lama, Auth::user()->password)) {
            return back()->withErrors(['password_lama' => 'Password lama tidak sesuai.']);
        }

        Auth::user()->update(['password' => Hash::make($request->password_baru)]);

        return back()->with('success', 'Password berhasil diganti.');
    }
}