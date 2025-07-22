<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Petugas extends Model
{
    use HasFactory;

    protected $table = 'petugas';
    protected $fillable = ['user_id', 'struktur_inspektorat_id', 'struktur_kecamatan_id', 'struktur_desa_id', 'status_jab', 'status', 'nip', 'photo'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function pegawai()
    {
        return $this->belongsTo(StrukturInspektorat::class, 'struktur_inspektorat_id');
    }
}
