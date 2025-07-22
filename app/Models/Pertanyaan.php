<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pertanyaan extends Model
{
    use HasFactory;
    protected $table = 'pertanyaan';

    protected $fillable = [
        'kategori_laporan_id',
        'jenis_laporan_id',
        'pertanyaan',
        'status',
    ];

    // Relasi ke kategori laporan
    public function kategori()
    {
        return $this->belongsTo(KategoriLaporan::class, 'kategori_laporan_id');
    }

    // Relasi ke jenis laporan
    public function jenis()
    {
        return $this->belongsTo(JenisLaporan::class, 'jenis_laporan_id');
    }
    public function dokumen()
    {
        return $this->belongsToMany(JenisDokumen::class, 'dokumen_pertanyaan', 'pertanyaan_id', 'dokumen_id');
    }
    public function jawabans()
    {
        return $this->hasMany(Jawaban::class);
    }
}
