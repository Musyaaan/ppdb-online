<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Pendaftaran;

class CetakBuktiController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $pendaftaran = Pendaftaran::with([
                'siswa',
                'dataOrangtua',
                'dokumen',
                'pendidikan',
                'buktiPendaftaran',
            ])
            ->where('id_user', $user->id_user)
            ->latest('tanggal_daftar')
            ->first();

        return view('dashboard.cetak', compact('pendaftaran'));
    }
}