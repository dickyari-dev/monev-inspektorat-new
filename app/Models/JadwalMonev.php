<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalMonev extends Model
{
    use HasFactory;
    protected $table = 'jadwal_monev'; // opsional, Laravel sudah bisa mengenali

    protected $fillable = [
        'id_petugas',
        'tanggal_awal',
        'tanggal_akhir',
        'id_waktu',
        'id_kecamatan',
        'id_desa',
    ];

    // Relasi ke WaktuMonev
    public function waktu()
    {
        return $this->belongsTo(WaktuMonev::class, 'id_waktu');
    }

    // Relasi ke Kecamatan
    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class, 'id_kecamatan');
    }

    // Relasi ke Desa
    public function desa()
    {
        return $this->belongsTo(Desa::class, 'id_desa');
    }
}
