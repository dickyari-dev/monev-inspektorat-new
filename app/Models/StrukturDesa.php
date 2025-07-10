<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StrukturDesa extends Model
{
    use HasFactory;
    protected $table = 'struktur_desa';

    protected $fillable = [
        'id_desa',
        'id_kecamatan',
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

    protected $casts = [
        'tahun_awal' => 'date',
        'tahun_akhir' => 'date',
    ];

    // Relasi
    public function desa()
    {
        return $this->belongsTo(Desa::class, 'id_desa');
    }

    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class, 'id_kecamatan');
    }

    public function jabatan()
    {
        return $this->belongsTo(JenisJabatan::class, 'id_jabatan');
    }
}
