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
        Schema::create('struktur_inspektorat', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('id_jabatan');
            $table->string('nip')->nullable();
            $table->string('nama_pegawai');
            $table->date('tahun_awal')->nullable();
            $table->date('tahun_akhir')->nullable();
            $table->string('telephone')->nullable();
            $table->text('alamat')->nullable();
            $table->string('foto')->nullable(); // path file foto
            $table->string('status')->default('active');

            $table->timestamps();

            // Foreign Key
            $table->foreign('id_jabatan')->references('id')->on('jenis_jabatan')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('struktur_inspektorat');
    }
};
