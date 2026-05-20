<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pendaftaran extends Model
{
    public $timestamps    = false;
    protected $table      = 'pendaftaran';
    protected $primaryKey = 'id_pendaftaran';

    protected $fillable = [
        'id_user',
        'tanggal_daftar',
        'status',
        'catatan_admin',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    public function siswa()
    {
        return $this->hasOne(Siswa::class, 'id_pendaftaran', 'id_pendaftaran');
    }

    public function dataOrangtua()
    {
        return $this->hasOne(DataOrangtua::class, 'id_pendaftaran', 'id_pendaftaran');
    }

    public function pendidikan()
    {
        return $this->hasOne(Pendidikan::class, 'id_pendaftaran', 'id_pendaftaran');
    }

    public function dokumen()
    {
        return $this->hasMany(Dokumen::class, 'id_pendaftaran', 'id_pendaftaran');
    }

    public function buktiPendaftaran()
    {
        return $this->hasOne(BuktiPendaftaran::class, 'id_pendaftaran', 'id_pendaftaran');
    }
}