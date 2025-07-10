<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Desa extends Model
{
    use HasFactory;
    protected $table = 'desa';

    protected $fillable = [
        'kode_desa',
        'nama_desa',
        'kecamatan_id',
        'alamat',
        'telepon',
        'status',
    ];

    // Relasi ke kecamatan
    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class);
    }
}
