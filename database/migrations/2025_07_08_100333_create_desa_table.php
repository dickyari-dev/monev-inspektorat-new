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
        Schema::create('desa', function (Blueprint $table) {
            $table->id();
            $table->string('kode_desa')->unique(); // kode desa harus unik
            $table->string('nama_desa');

            // Relasi ke kecamatan
            $table->unsignedBigInteger('kecamatan_id');
            $table->foreign('kecamatan_id')->references('id')->on('kecamatan')->onDelete('cascade');

            $table->string('alamat')->nullable();
            $table->string('telepon', 20)->nullable();
            $table->string('status')->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('desa');
    }
};
