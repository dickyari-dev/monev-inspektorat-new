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
        Schema::create('waktu_monev', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_petugas')->nullable();
            $table->unsignedBigInteger('id_kategori_laporan');
            $table->unsignedBigInteger('id_jenis_laporan');
            $table->year('tahun'); // format tahun saja
            $table->tinyInteger('bulan'); // angka 1–12

            $table->date('tanggal_awal');
            $table->date('tanggal_akhir');

            $table->string('status')->default('active');

            $table->timestamps();

            // Foreign key constraints
            $table->foreign('id_petugas')->references('id')->on('petugas')->onDelete('set null');
            $table->foreign('id_kategori_laporan')->references('id')->on('kategori_laporan')->onDelete('cascade');
            $table->foreign('id_jenis_laporan')->references('id')->on('jenis_laporan')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('waktu_monev');
    }
};
