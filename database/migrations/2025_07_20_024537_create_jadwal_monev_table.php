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
        Schema::create('jadwal_monev', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_petugas')->nullable(); // tanpa relasi
            $table->date('tanggal_awal');
            $table->date('tanggal_akhir');

            // Foreign keys
            $table->unsignedBigInteger('id_waktu');
            $table->unsignedBigInteger('id_kecamatan');
            $table->unsignedBigInteger('id_desa');

            $table->timestamps();

            // Tambahkan relasi (foreign key constraints)
            $table->foreign('id_waktu')->references('id')->on('waktu_monev')->onDelete('cascade');
            $table->foreign('id_kecamatan')->references('id')->on('kecamatan')->onDelete('cascade');
            $table->foreign('id_desa')->references('id')->on('desa')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwal_monev');
    }
};
