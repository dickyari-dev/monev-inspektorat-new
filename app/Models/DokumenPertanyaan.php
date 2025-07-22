<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DokumenPertanyaan extends Model
{
    protected $table = 'dokumen_pertanyaan';

    protected $fillable = [
        'pertanyaan_id',
        'dokumen_id',
        'status',
    ];

    public function dokumen()
    {
        return $this->belongsTo(JenisDokumen::class);
    }


}
