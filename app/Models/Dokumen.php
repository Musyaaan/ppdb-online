<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Dokumen extends Model
{
    protected $table      = 'dokumen';
    protected $primaryKey = 'id_dokumen';

    // Tabel tidak punya created_at / updated_at — pakai tanggal_upload
    public $timestamps = false;

    protected $fillable = [
        'id_pendaftaran',
        'jenis_dokumen',
        'file_path',
        'status_verifikasi',
        'tanggal_upload',
    ];

    // Cast tanggal_upload sebagai Carbon date
    protected $casts = [
        'tanggal_upload' => 'date',
    ];

    // ── Relationships ──────────────────────────────────────────────────────

    public function pendaftaran(): BelongsTo
    {
        return $this->belongsTo(Pendaftaran::class, 'id_pendaftaran', 'id_pendaftaran');
    }
}