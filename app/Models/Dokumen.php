<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dokumen extends Model
{
    public $timestamps    = false;
    protected $table      = 'dokumen';
    protected $primaryKey = 'id_dokumen';

    protected $fillable = [
        'id_pendaftaran',
        'jenis_dokumen',
        'file_path',
        'status_verifikasi',
        'tanggal_upload',
    ];

    public function pendaftaran()
    {
        return $this->belongsTo(Pendaftaran::class, 'id_pendaftaran', 'id_pendaftaran');
    }
}