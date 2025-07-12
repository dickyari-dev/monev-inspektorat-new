<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WaktuMonev extends Model
{
    use HasFactory;
     protected $table = 'waktu_monev';

    protected $fillable = [
        'id_petugas',
        'id_kategori_laporan',
        'id_jenis_laporan',
        'tahun',
        'bulan',
        'tanggal_awal',
        'tanggal_akhir',
        'status',
    ];

    public function petugas()
    {
        return $this->belongsTo(Petugas::class, 'id_petugas');
    }

    public function kategori()
    {
        return $this->belongsTo(KategoriLaporan::class, 'id_kategori_laporan');
    }

    public function jenis()
    {
        return $this->belongsTo(JenisLaporan::class, 'id_jenis_laporan');
    }
}
