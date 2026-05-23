<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class FormulirController extends Controller
{
    // ─────────────────────────────────────────
    // GET /formulir
    // ─────────────────────────────────────────
    public function index()
    {
        $pendaftaran = DB::table('pendaftaran')
            ->where('id_user', Auth::id())
            ->whereIn('status', ['pending', 'diperbaiki', 'diterima', 'ditolak', 'draft'])
            ->first();

        $siswa    = $pendaftaran ? DB::table('siswa')->where('id_pendaftaran', $pendaftaran->id_pendaftaran)->first() : null;
        $orangtua = $pendaftaran ? DB::table('data_orangtua')->where('id_pendaftaran', $pendaftaran->id_pendaftaran)->first() : null;

        return view('dashboard.formulir', compact('pendaftaran', 'siswa', 'orangtua'));
    }

    // ─────────────────────────────────────────
    // POST /formulir/submit
    // ─────────────────────────────────────────
    public function submit(Request $request)
    {
        // ── Validasi ──────────────────────────────────────────────
        $request->validate([
            'nama_siswa'     => 'required|string|max:100',
            'tgl_lahir'      => 'required|date',
            'jenis_kelamin'  => 'required|in:L,P',
            'alamat'         => 'required|string',
            'nama_ayah'      => 'required|string|max:100',
            'nama_ibu'       => 'required|string|max:100',
            'pekerjaan_ayah' => 'required|string|max:100',
            'pekerjaan_ibu'  => 'required|string|max:100',
            'no_hp'          => ['required', 'string', 'max:20', 'regex:/^08[0-9]{7,12}$/'],
        ], [
            'nama_siswa.required'     => 'Nama siswa wajib diisi.',
            'tgl_lahir.required'      => 'Tanggal lahir wajib diisi.',
            'jenis_kelamin.required'  => 'Jenis kelamin wajib dipilih.',
            'alamat.required'         => 'Alamat wajib diisi.',
            'nama_ayah.required'      => 'Nama ayah wajib diisi.',
            'nama_ibu.required'       => 'Nama ibu wajib diisi.',
            'pekerjaan_ayah.required' => 'Pekerjaan ayah wajib dipilih.',
            'pekerjaan_ibu.required'  => 'Pekerjaan ibu wajib dipilih.',
            'no_hp.required'          => 'Nomor HP wajib diisi.',
            'no_hp.regex'             => 'Format nomor HP tidak valid (contoh: 081234567890).',
        ]);

        // ── Validasi usia (server-side) ───────────────────────────
        $tglLahir   = Carbon::parse($request->tgl_lahir);
        $batas      = Carbon::create(now()->year, 7, 1);
        $totalBulan = $tglLahir->diffInMonths($batas);
        $lulusanTK  = $request->input('lulusan_tk') === 'ya';
        $minBulan   = $lulusanTK ? 80 : 84;

        if ($totalBulan < $minBulan || $totalBulan >= 96) {
            return back()->withInput()
                ->withErrors(['tgl_lahir' => 'Usia calon siswa tidak memenuhi syarat pendaftaran (terlalu muda atau terlalu tua).']);
        }

        // ── Cek status — tolak edit kalau sudah final ─────────────
        $sudahFinal = DB::table('pendaftaran')
            ->where('id_user', Auth::id())
            ->whereIn('status', ['diterima', 'ditolak'])
            ->first();

        if ($sudahFinal) {
            return back()->with('error', 'Pendaftaran sudah diproses, tidak dapat diubah.');
        }

        // ── Simpan ke DB (transaction) ────────────────────────────
        DB::transaction(function () use ($request) {
            $userId = Auth::id();

            $existing = DB::table('pendaftaran')
                ->where('id_user', $userId)
                ->whereIn('status', ['pending', 'diperbaiki', 'draft'])
                ->first();

         

            $dataSiswa = [
    'nama_siswa'    => $request->nama_siswa,
    'tempat_lahir'  => $request->tempat_lahir,
    'tanggal_lahir' => $request->tgl_lahir,
    'jenis_kelamin' => $request->jenis_kelamin,
    'agama'         => $request->agama,
    'alamat'        => $request->alamat,
];

            $dataOrtu = [
                'nama_ayah'      => $request->nama_ayah,
                'nama_ibu'       => $request->nama_ibu,
                'pekerjaan_ayah' => $request->pekerjaan_ayah,
                'pekerjaan_ibu'  => $request->pekerjaan_ibu,
                'no_hp'          => $request->no_hp,
            ];

            if ($existing) {
                DB::table('pendaftaran')
                    ->where('id_pendaftaran', $existing->id_pendaftaran)
                    ->update([
                        'tanggal_daftar' => now()->toDateString(),
                        'status'         => 'pending',
                    ]);

                $id = $existing->id_pendaftaran;

                if (DB::table('siswa')->where('id_pendaftaran', $id)->exists()) {
                    DB::table('siswa')->where('id_pendaftaran', $id)->update($dataSiswa);
                } else {
                    DB::table('siswa')->insert(array_merge($dataSiswa, ['id_pendaftaran' => $id]));
                }

                if (DB::table('data_orangtua')->where('id_pendaftaran', $id)->exists()) {
                    DB::table('data_orangtua')->where('id_pendaftaran', $id)->update($dataOrtu);
                } else {
                    DB::table('data_orangtua')->insert(array_merge($dataOrtu, ['id_pendaftaran' => $id]));
                }

            } else {
                $id = DB::table('pendaftaran')->insertGetId([
                    'id_user'        => $userId,
                    'tanggal_daftar' => now()->toDateString(),
                    'status'         => 'pending',
                ]);

                DB::table('siswa')->insert(array_merge($dataSiswa, ['id_pendaftaran' => $id]));
                DB::table('data_orangtua')->insert(array_merge($dataOrtu, ['id_pendaftaran' => $id]));
            }
        });

        return redirect()->route('cetak.index')
            ->with('success', 'Pendaftaran berhasil dikirim! Silakan cetak bukti pendaftaran.');
    }

    public function saveStep1(Request $request) { return redirect()->route('formulir.index'); }
    public function saveStep2(Request $request) { return redirect()->route('formulir.index'); }
    public function saveStep3(Request $request) { return redirect()->route('formulir.index'); }
}