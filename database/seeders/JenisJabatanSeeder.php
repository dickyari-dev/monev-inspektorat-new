<?php

namespace Database\Seeders;

use App\Models\JenisJabatan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JenisJabatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['nama_jabatan' => 'Kepala Seksi', 'kategori' => 'i', 'status' => 'active'],
            ['nama_jabatan' => 'Staf Administrasi', 'kategori' => 'k', 'status' => 'active'],
            ['nama_jabatan' => 'Tenaga Teknis', 'kategori' => 'd', 'status' => 'inactive'],
            ['nama_jabatan' => 'Manajer Operasional', 'kategori' => 'i', 'status' => 'active'],
            ['nama_jabatan' => 'Pengawas Lapangan', 'kategori' => null, 'status' => 'active'],
        ];

        foreach ($data as $item) {
            JenisJabatan::create($item);
        }
    }
}
