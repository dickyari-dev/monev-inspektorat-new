<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StrukturInspektorat extends Model
{
    use HasFactory;

    protected $table = 'struktur_inspektorat';

    protected $fillable = [
        'id_jabatan',
        'nip',
        'nama_pegawai',
        'tahun_awal',
        'tahun_akhir',
        'telephone',
        'alamat',
        'foto',
        'status',
    ];

    public function jabatan()
    {
        return $this->belongsTo(JenisJabatan::class, 'id_jabatan');
    }
}
