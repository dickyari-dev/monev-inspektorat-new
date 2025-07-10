<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisLaporan extends Model
{
    use HasFactory;
    protected $table = 'jenis_laporan';

    protected $fillable = [
        'kategori_id',
        'nama_jenis_laporan',
        'status',
    ];

    /**
     * Relasi ke model KategoriLaporan
     */
    public function kategoriLaporan()
    {
        return $this->belongsTo(KategoriLaporan::class, 'kategori_id');
    }
}
