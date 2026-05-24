<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    public    $timestamps = false;
    protected $table      = 'siswa';
    protected $primaryKey = 'id_siswa';

    protected $fillable = [
        'id_pendaftaran',
        'nama_siswa',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'agama',
        'nik_siswa',
        'alamat',
        'kelurahan',
        'kecamatan',
        'kode_pos',
        'anak_ke',
        'jml_saudara',
        'lulusan_tk',
        'nama_tk',
    ];

    public function pendaftaran()
    {
        return $this->belongsTo(Pendaftaran::class, 'id_pendaftaran', 'id_pendaftaran');
    }
}