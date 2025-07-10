<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StrukturKecamatan extends Model
{
    use HasFactory;
    protected $table = 'struktur_kecamatan';

    protected $fillable = [
        'id_kecamatan',
        'id_jabatan',
        'nip',
        'nama_pegawai',
        'tahun_awal',
        'tahun_akhir',
        'telephone',
        'alamat',
        'foto',
        'status',
    ];

    // Relasi ke Jenis Jabatan
    public function jabatan()
    {
        return $this->belongsTo(JenisJabatan::class, 'id_jabatan');
    }
    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class, 'id_kecamatan');
    }
}
