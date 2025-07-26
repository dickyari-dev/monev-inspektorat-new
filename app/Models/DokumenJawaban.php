<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DokumenJawaban extends Model
{
    use HasFactory;

    protected $table = 'dokumen_jawaban';
    protected $fillable = [
        'jawaban_id',
        'desa_id',
        'jenis_dokumen_id',
        'dokumen',
        'status',
        'keterangan_pengirim',
        'keterangan_penerima',
    ];

    // Relasi ke jawaban
    public function jawaban()
    {
        return $this->belongsTo(Jawaban::class);
    }

    // Relasi ke desa
    public function desa()
    {
        return $this->belongsTo(Desa::class);
    }

    // Relasi ke jenis dokumen
    public function jenisDokumen()
    {
        return $this->belongsTo(JenisDokumen::class);
    }
}
