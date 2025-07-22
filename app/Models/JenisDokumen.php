<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisDokumen extends Model
{
    use HasFactory;
    protected $table = 'jenis_dokumen';

    protected $fillable = [
        'nama_dokumen',
        'dokumen_rujukan',
        'status',
    ];

    public function pertanyaan()
    {
        return $this->belongsToMany(Pertanyaan::class, 'dokumen_pertanyaan', 'dokumen_id', 'pertanyaan_id');
    }
}
