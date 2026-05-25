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
    public function index()
    {
        $user = Auth::user();

        $pendaftaran  = Pendaftaran::where('id_user', $user->id_user)->first();
        $siswa        = null;
        $dokumen      = collect();
        $bukti        = null;
        $progressStep = 0;

        if ($pendaftaran) {

            $siswa   = Siswa::where('id_pendaftaran', $pendaftaran->id_pendaftaran)->first();
            $dokumen = Dokumen::where('id_pendaftaran', $pendaftaran->id_pendaftaran)->get();
            $bukti   = BuktiPendaftaran::where('id_pendaftaran', $pendaftaran->id_pendaftaran)->first();

            // Step 1 — Formulir sudah diisi
            $progressStep = 1;

            // Step 2 — 4 dokumen wajib sudah terupload (KK, Akta, KTP Ortu, Pas Foto)
$dokumenWajibCount = $dokumen
    ->whereIn('jenis_dokumen', ['kartu_keluarga', 'akta_kelahiran', 'ktp_orang_tua', 'pas_foto'])
    ->count();

if ($dokumenWajibCount >= 4) {
    $progressStep = 2;
}

            // Step 3 — Bukti pendaftaran sudah dicetak / di-download
            if ($bukti && $bukti->sudah_dicetak) {
                $progressStep = 3;
            }

            // Step 4 — Admin sudah memproses (status berubah dari pending/draft)
            if (in_array($pendaftaran->status, ['diterima', 'ditolak', 'diperbaiki'])) {
                $progressStep = 4;
            }

            // Step 5 — Status penerimaan final
            if (in_array($pendaftaran->status, ['diterima', 'ditolak'])) {
                $progressStep = 5;
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