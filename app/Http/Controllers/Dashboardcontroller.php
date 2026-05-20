<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Pendaftaran;
use App\Models\Siswa;
use App\Models\Dokumen;
use App\Models\BuktiPendaftaran;

class DashboardController extends Controller
{
    // =========================================================
    // DASHBOARD UTAMA ORANG TUA
    // =========================================================

    public function index()
    {
        $user = Auth::user();

        // AMBIL DATA PENDAFTARAN MILIK USER INI
        $pendaftaran = Pendaftaran::where('id_user', $user->id_user)->first();

        $siswa          = null;
        $dokumen        = [];
        $bukti          = null;
        $progressStep   = 0;

        if ($pendaftaran) {
            $siswa   = \App\Models\Siswa::where('id_pendaftaran', $pendaftaran->id_pendaftaran)->first();
            $dokumen = Dokumen::where('id_pendaftaran', $pendaftaran->id_pendaftaran)->get();
            $bukti   = BuktiPendaftaran::where('id_pendaftaran', $pendaftaran->id_pendaftaran)->first();

            // HITUNG PROGRESS STEP
            // Step 1: Pendaftaran dibuat
            $progressStep = 1;

            // Step 2: Dokumen sudah diupload semua
            if ($dokumen->count() >= 4) {
                $progressStep = 2;
            }

            // Step 3: Bukti pendaftaran sudah dicetak
            if ($bukti) {
                $progressStep = 3;
            }
        }

        return view('dashboard.index', compact(
            'user',
            'pendaftaran',
            'siswa',
            'dokumen',
            'bukti',
            'progressStep'
        ));
    }
}