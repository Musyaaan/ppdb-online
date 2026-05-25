<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Pendaftaran;
use App\Models\BuktiPendaftaran;

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

    public function markDone()
    {
        $user        = Auth::user();
        $pendaftaran = Pendaftaran::where('id_user', $user->id_user)->first();

        if (!$pendaftaran) {
            return response()->json(['success' => false, 'message' => 'Pendaftaran tidak ditemukan.'], 404);
        }

        $noBukti = 'PPDB-' . str_pad($pendaftaran->id_pendaftaran, 5, '0', STR_PAD_LEFT);

        BuktiPendaftaran::updateOrCreate(
            ['id_pendaftaran' => $pendaftaran->id_pendaftaran],
            [
                'nomor_bukti'   => $noBukti,
                'sudah_dicetak' => true,
                'tanggal_cetak' => now(),
            ]
        );

        return response()->json(['success' => true]);
    }
}