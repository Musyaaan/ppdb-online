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
        // Sudah punya pendaftaran aktif (bukan draft) → redirect ke cetak
        $aktif = DB::table('pendaftaran')
            ->where('id_user', Auth::id())
            ->whereIn('status', ['pending', 'diperbaiki', 'diterima', 'ditolak'])
            ->first();

        if ($aktif) {
            return redirect()->route('cetak.index')
                ->with('info', 'Anda sudah memiliki pendaftaran yang sedang diproses.');
        }

        // Cek draft (belum submit) → prefill form
        $draft    = DB::table('pendaftaran')
                        ->where('id_user', Auth::id())
                        ->where('status', 'draft')
                        ->first();

        $siswa    = $draft ? DB::table('siswa')->where('id_pendaftaran', $draft->id_pendaftaran)->first()        : null;
        $orangtua = $draft ? DB::table('data_orangtua')->where('id_pendaftaran', $draft->id_pendaftaran)->first() : null;

        return view('dashboard.formulir', compact('draft', 'siswa', 'orangtua'));
    }

    // ─────────────────────────────────────────
    // POST /formulir/submit  →  validasi + simpan ke DB
    // ─────────────────────────────────────────
    public function submit(Request $request)
    {
        // ── Validasi ──────────────────────────────────────────────
        $request->validate([
            // Data Siswa
            'nama_siswa'    => 'required|string|max:100',
            'tgl_lahir'     => 'required|date',
            'jenis_kelamin' => 'required|in:L,P',
            'alamat'        => 'required|string',
            // Data Ortu
            'nama_ayah'     => 'required|string|max:100',
            'nama_ibu'      => 'required|string|max:100',
            'pekerjaan_ayah'=> 'required|string|max:100',
            'pekerjaan_ibu' => 'required|string|max:100',
            'no_hp'         => ['required', 'string', 'max:20', 'regex:/^08[0-9]{7,12}$/'],
        ], [
            'nama_siswa.required'    => 'Nama siswa wajib diisi.',
            'tgl_lahir.required'     => 'Tanggal lahir wajib diisi.',
            'jenis_kelamin.required' => 'Jenis kelamin wajib dipilih.',
            'alamat.required'        => 'Alamat wajib diisi.',
            'nama_ayah.required'     => 'Nama ayah wajib diisi.',
            'nama_ibu.required'      => 'Nama ibu wajib diisi.',
            'pekerjaan_ayah.required'=> 'Pekerjaan ayah wajib dipilih.',
            'pekerjaan_ibu.required' => 'Pekerjaan ibu wajib dipilih.',
            'no_hp.required'         => 'Nomor HP wajib diisi.',
            'no_hp.regex'            => 'Format nomor HP tidak valid (contoh: 081234567890).',
        ]);

        // ── Validasi usia (server-side double check) ──────────────
        $tglLahir     = Carbon::parse($request->tgl_lahir);
        $batas        = Carbon::create(now()->year, 7, 1);
        $totalBulan   = $tglLahir->diffInMonths($batas);
        $lulusanTK    = $request->input('lulusan_tk') === 'ya';
        $minBulan     = $lulusanTK ? 80 : 84;

        if ($totalBulan < $minBulan) {
            return back()->withInput()
                ->withErrors(['tgl_lahir' => 'Usia calon siswa belum memenuhi syarat minimal pendaftaran.']);
        }

        // ── Simpan ke DB (transaction) ────────────────────────────
        DB::transaction(function () use ($request) {
            $userId = Auth::id();

            // Cek draft existing
            $draft = DB::table('pendaftaran')
                ->where('id_user', $userId)
                ->where('status', 'draft')
                ->first();

            // Data siswa — hanya kolom yang ada di tabel
            $dataSiswa = [
                'nama_siswa'    => $request->nama_siswa,
                'tanggal_lahir' => $request->tgl_lahir,
                'jenis_kelamin' => $request->jenis_kelamin,
                'alamat'        => $request->alamat,
            ];

            // Data orang tua — hanya kolom yang ada di tabel
            $dataOrtu = [
                'nama_ayah'      => $request->nama_ayah,
                'nama_ibu'       => $request->nama_ibu,
                'pekerjaan_ayah' => $request->pekerjaan_ayah,
                'pekerjaan_ibu'  => $request->pekerjaan_ibu,
                'no_hp'          => $request->no_hp,
            ];

            if ($draft) {
                // UPDATE pendaftaran → pending
                DB::table('pendaftaran')->where('id_pendaftaran', $draft->id_pendaftaran)->update([
                    'tanggal_daftar' => now()->toDateString(),
                    'status'         => 'pending',
                ]);

                $id = $draft->id_pendaftaran;

                // UPSERT siswa
                if (DB::table('siswa')->where('id_pendaftaran', $id)->exists()) {
                    DB::table('siswa')->where('id_pendaftaran', $id)->update($dataSiswa);
                } else {
                    DB::table('siswa')->insert(array_merge($dataSiswa, ['id_pendaftaran' => $id]));
                }

                // UPSERT data_orangtua
                if (DB::table('data_orangtua')->where('id_pendaftaran', $id)->exists()) {
                    DB::table('data_orangtua')->where('id_pendaftaran', $id)->update($dataOrtu);
                } else {
                    DB::table('data_orangtua')->insert(array_merge($dataOrtu, ['id_pendaftaran' => $id]));
                }

            } else {
                // INSERT baru
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

    // ─────────────────────────────────────────
    // Stub routes yang masih ada di web.php
    // (tidak dipakai blade tapi harus ada agar
    //  tidak RouteNotFound saat artisan route:list)
    // ─────────────────────────────────────────
    public function saveStep1(Request $request) { return redirect()->route('formulir.index'); }
    public function saveStep2(Request $request) { return redirect()->route('formulir.index'); }
    public function saveStep3(Request $request) { return redirect()->route('formulir.index'); }
}