<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    public $timestamps    = false;
    protected $table      = 'siswa';
    protected $primaryKey = 'id_siswa';

    protected $fillable = [
        'id_pendaftaran',
        'nama_siswa',
        'tanggal_lahir',
        'jenis_kelamin',
        'alamat',
    ];

    public function pendaftaran()
    {
        return $this->belongsTo(Pendaftaran::class, 'id_pendaftaran', 'id_pendaftaran');
    }
}