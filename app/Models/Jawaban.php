<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jawaban extends Model
{
    use HasFactory;
     protected $fillable = [
        'pertanyaan_id',
        'desa_id',
        'jawaban',
    ];

    // Relasi ke Pertanyaan
    public function pertanyaan()
    {
        return $this->belongsTo(Pertanyaan::class);
    }

    // Relasi ke Desa
    public function desa()
    {
        return $this->belongsTo(Desa::class);
    }
}
