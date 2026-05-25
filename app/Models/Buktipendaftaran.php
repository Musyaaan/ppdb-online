<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BuktiPendaftaran extends Model
{
    public $timestamps    = false;
    protected $table      = 'bukti_pendaftaran';
    protected $primaryKey = 'id_bukti';

    protected $fillable = [
        'id_pendaftaran',
        'nomor_bukti',
        'file_bukti',
        'tanggal_cetak',
        'status_cetak',
        'sudah_dicetak',
    ];

    public function pendaftaran()
    {
        return $this->belongsTo(Pendaftaran::class, 'id_pendaftaran', 'id_pendaftaran');
    }
}