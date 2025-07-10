<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin Desa',
            'email' => 'desa@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'desa'
        ]);

        User::create([
            'name' => 'Admin Kecamatan',
            'email' => 'kecamatan@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'kecamatan'
        ]);

        User::create([
            'name' => 'Admin Inspektorat',
            'email' => 'inspektorat@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'inspektorat'
        ]);
    }
}
