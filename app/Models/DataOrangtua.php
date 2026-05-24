<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataOrangtua extends Model
{
    protected $table      = 'data_orangtua';
    protected $primaryKey = 'id_data_orangtua';
    public    $timestamps = false;

    protected $fillable = [
        'id_pendaftaran',
        'nama_ayah',
        'nik_ayah',
        'nama_ibu',
        'nik_ibu',
        'pekerjaan_ayah',
        'pendidikan_ayah',
        'pekerjaan_ibu',
        'pendidikan_ibu',
        'no_hp',
        'email',
        'alamat_ortu',
        'nama_wali',
        'hub_wali',
        'nik_wali',
        'no_hp_wali',
    ];

    public function pendaftaran()
    {
        return $this->belongsTo(Pendaftaran::class, 'id_pendaftaran', 'id_pendaftaran');
    }
}