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
        Schema::create('dokumen_jawaban', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('jawaban_id')->nullable();
            $table->foreign('jawaban_id')->references('id')->on('jawabans')->onDelete('cascade');
            $table->unsignedBigInteger('desa_id');
            $table->foreign('desa_id')->references('id')->on('desa')->onDelete('cascade');
            $table->unsignedBigInteger('jenis_dokumen_id');
            $table->foreign('jenis_dokumen_id')->references('id')->on('jenis_dokumen')->onDelete('cascade');
            $table->string('dokumen')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dokumen_jawaban');
    }
};
