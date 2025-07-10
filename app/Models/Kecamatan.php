<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kecamatan extends Model
{
    use HasFactory;

    protected $table = 'kecamatan';

    protected $fillable = [
        'kode_kecamatan',
        'nama_kecamatan',
        'nama_kabupaten',
        'alamat',
        'kode_pos',
        'telepon',
        'status',
    ];
}
