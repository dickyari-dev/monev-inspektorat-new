<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriLaporan extends Model
{
    use HasFactory;
    protected $table = 'kategori_laporan';

    protected $fillable = [
        'nama_kategori_laporan',
        'status',
    ];
}
