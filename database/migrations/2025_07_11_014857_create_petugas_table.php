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
        Schema::create('petugas', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('struktur_inspektorat_id')->nullable();
            $table->unsignedBigInteger('struktur_kecamatan_id')->nullable();
            $table->unsignedBigInteger('struktur_desa_id')->nullable();

            $table->enum('status_jab', ['kepala', 'petugas']);
            $table->string('status')->default('active');

            $table->timestamps();

            // Foreign keys
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('struktur_inspektorat_id')->references('id')->on('struktur_inspektorat')->onDelete('set null');
            $table->foreign('struktur_kecamatan_id')->references('id')->on('struktur_kecamatan')->onDelete('set null');
            $table->foreign('struktur_desa_id')->references('id')->on('struktur_desa')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('petugas');
    }
};
