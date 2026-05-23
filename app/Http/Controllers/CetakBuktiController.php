<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CetakBuktiController extends Controller
{
    public function index()
    {
        $pendaftaran = DB::table('pendaftaran')
            ->where('id_user', Auth::id())
            ->whereIn('status', ['pending', 'diperbaiki', 'diterima', 'ditolak'])
            ->first();

        if (!$pendaftaran) {
            return redirect()->route('formulir.index')
                ->with('info', 'Belum ada pendaftaran yang disubmit.');
        }

        $siswa    = DB::table('siswa')
                        ->where('id_pendaftaran', $pendaftaran->id_pendaftaran)
                        ->first();

        $orangtua = DB::table('data_orangtua')
                        ->where('id_pendaftaran', $pendaftaran->id_pendaftaran)
                        ->first();

        return view('dashboard.cetak', compact('pendaftaran', 'siswa', 'orangtua'));
    }
}