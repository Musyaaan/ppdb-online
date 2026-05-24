<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pendidikan extends Model
{
    protected $table      = 'pendidikan';
    protected $primaryKey = 'id_pendidikan';
    public    $timestamps = false;

    protected $fillable = [
        'id_pendaftaran',
        'asal_sekolah',
        'tahun_lulus',
    ];

    public function pendaftaran()
    {
        return $this->belongsTo(Pendaftaran::class, 'id_pendaftaran', 'id_pendaftaran');
    }
}