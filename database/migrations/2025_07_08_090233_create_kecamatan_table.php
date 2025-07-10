<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('kecamatan', function (Blueprint $table) {
            $table->id();
            $table->string('kode_kecamatan')->unique(); // unik karena kode kecamatan harus unik
            $table->string('nama_kecamatan');
            
            // Jika kabupaten adalah relasi ke tabel kabupaten
            $table->string('nama_kabupaten')->nullable();
           
            $table->string('alamat')->nullable();
            $table->string('kode_pos', 20)->nullable();     // gunakan string, bisa ada nol di depan
            $table->string('telepon', 20)->nullable();      // gunakan string agar fleksibel
            $table->string('status')->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kecamatan');
    }
};
