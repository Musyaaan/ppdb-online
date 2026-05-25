<?php

namespace App\Http\Controllers;

use App\Models\Dokumen;
use App\Models\Pendaftaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DokumenController extends Controller
{
    private array $jenisLabel = [
    'kartu_keluarga' => 'Kartu Keluarga (KK)',
    'akta_kelahiran' => 'Akta Kelahiran',
    'ktp_orang_tua'  => 'KTP Orang Tua / Wali',
    'ijazah_tk'      => 'Ijazah TK',
    'pas_foto'       => 'Pas Foto 3×4',          // ← tambah
];

    private array $wajib = ['kartu_keluarga', 'akta_kelahiran', 'ktp_orang_tua', 'pas_foto'];

    public function index()
    {
        $pendaftaran = Pendaftaran::where('id_user', Auth::id())->first();
        $dokumen = collect();

        if ($pendaftaran) {
            $dokumen = Dokumen::where('id_pendaftaran', $pendaftaran->id_pendaftaran)
                              ->orderByDesc('tanggal_upload')
                              ->get()
                              ->map(function ($item) {
                                  $item->jenis_label = $this->jenisLabel[$item->jenis_dokumen] ?? $item->jenis_dokumen;
                                  $item->ekstensi    = strtolower(pathinfo($item->file_path, PATHINFO_EXTENSION));
                                  $item->nama_asli   = basename($item->file_path);
                                  return $item;
                              });
        }

        return view('dokumen.index', compact('dokumen', 'pendaftaran'));
    }

    public function upload(Request $request)
    {
        $request->validate([
'jenis_dokumen' => ['required', 'in:kartu_keluarga,akta_kelahiran,ktp_orang_tua,ijazah_tk,pas_foto'],
            'file'          => ['required', 'file', 'max:5120', 'mimes:jpg,jpeg,png,pdf'],
        ], [
            'jenis_dokumen.required' => 'Pilih jenis dokumen terlebih dahulu.',
            'jenis_dokumen.in'       => 'Jenis dokumen tidak valid.',
            'file.required'          => 'Pilih file yang akan diunggah.',
            'file.max'               => 'Ukuran file maksimal 5MB.',
            'file.mimes'             => 'Format file harus JPG, PNG, atau PDF.',
        ]);

        $pendaftaran = Pendaftaran::where('id_user', Auth::id())->first();

        if (!$pendaftaran) {
            return redirect()->route('dokumen.index')
                ->with('error', 'Anda belum memiliki data pendaftaran.');
        }

        $file          = $request->file('file');
        $jenis         = $request->jenis_dokumen;
        $idPendaftaran = $pendaftaran->id_pendaftaran;

        // ── Auto-rename ──────────────────────────────────────────────
        $namaUser  = Str::slug(Auth::user()->nama, '_');
        $ext       = strtolower($file->getClientOriginalExtension());
        $timestamp = now()->format('Ymd_His');
        $random    = Str::random(6);
        $namaFile  = "{$jenis}_{$namaUser}_{$timestamp}_{$random}.{$ext}";
        // ─────────────────────────────────────────────────────────────

        // Hapus dokumen jenis yang sama jika sudah ada
        $existing = Dokumen::where('id_pendaftaran', $idPendaftaran)
                           ->where('jenis_dokumen', $jenis)
                           ->first();

        if ($existing) {
            $pathLama = str_replace('storage/', '', $existing->file_path);
            if (Storage::disk('public')->exists($pathLama)) {
                Storage::disk('public')->delete($pathLama);
            }
            $existing->delete();
        }

        // Simpan file
        $path = $file->storeAs("dokumen/{$idPendaftaran}", $namaFile, 'public');

        Dokumen::create([
            'id_pendaftaran'    => $idPendaftaran,
            'jenis_dokumen'     => $jenis,
            'file_path'         => 'storage/' . $path,
            'status_verifikasi' => 'pending',
            'tanggal_upload'    => now()->toDateString(),
        ]);

        // ── Buat/perbarui ZIP jika 3 dokumen wajib sudah ada ────────
        $this->buatZipJikaLengkap($idPendaftaran, $namaUser);
        // ─────────────────────────────────────────────────────────────

        return redirect()->route('dokumen.index')
            ->with('success', "Dokumen \"{$this->jenisLabel[$jenis]}\" berhasil diunggah.");
    }

    /**
     * Buat/perbarui ZIP dokumen user.
     * Zip dibuat jika KK + Akta Kelahiran + KTP Orang Tua sudah terupload.
     * Ijazah TK ikut masuk jika ada.
     * Menggunakan PharData (built-in PHP, tanpa library eksternal).
     */
    private function buatZipJikaLengkap(int $idPendaftaran, string $namaUser): void
    {
        $dokumen = Dokumen::where('id_pendaftaran', $idPendaftaran)->get()
                          ->keyBy('jenis_dokumen');

        foreach ($this->wajib as $w) {
            if (!isset($dokumen[$w])) return;
        }

        $files = [];
        foreach (array_merge($this->wajib, ['ijazah_tk']) as $jenis) {
            if (!isset($dokumen[$jenis])) continue;

            $relativePath = str_replace('storage/', '', $dokumen[$jenis]->file_path);
            $absPath      = Storage::disk('public')->path($relativePath);

            if (file_exists($absPath)) {
                $files[$jenis] = $absPath;
            }
        }

        if (empty($files)) return;

        $zipDir  = Storage::disk('public')->path("dokumen/{$idPendaftaran}");
        $zipPath = "{$zipDir}/dokumen_{$namaUser}.zip";

        if (file_exists($zipPath)) unlink($zipPath);

        // Salin file ke folder temp
        $tempDir = sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'zip_' . uniqid();
        mkdir($tempDir);

        foreach ($files as $absPath) {
            copy($absPath, $tempDir . DIRECTORY_SEPARATOR . basename($absPath));
        }

        // Buat zip menggunakan PharData (built-in PHP)
        $phar = new \PharData($zipPath);
        $phar->buildFromDirectory($tempDir);

        // Bersihkan folder temp
        foreach (scandir($tempDir) as $f) {
            if ($f !== '.' && $f !== '..') unlink($tempDir . DIRECTORY_SEPARATOR . $f);
        }
        rmdir($tempDir);
    }

    public function destroy(string $id)
    {
        $pendaftaran = Pendaftaran::where('id_user', Auth::id())->firstOrFail();

        $dokumen = Dokumen::where('id_dokumen', $id)
                          ->where('id_pendaftaran', $pendaftaran->id_pendaftaran)
                          ->firstOrFail();

        $pathFisik = str_replace('storage/', '', $dokumen->file_path);
        if (Storage::disk('public')->exists($pathFisik)) {
            Storage::disk('public')->delete($pathFisik);
        }

        $label = $this->jenisLabel[$dokumen->jenis_dokumen] ?? $dokumen->jenis_dokumen;
        $dokumen->delete();

        $namaUser = Str::slug(Auth::user()->nama, '_');
        $this->buatZipJikaLengkap($pendaftaran->id_pendaftaran, $namaUser);

        return redirect()->route('dokumen.index')
            ->with('success', "Dokumen \"{$label}\" berhasil dihapus.");
    }
}
