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
        Schema::create('jenis_jabatan', function (Blueprint $table) {
            $table->id();
            $table->string('nama_jabatan');
            $table->enum('kategori', ['i', 'k', 'd'])->nullable(); // i = internal, k = kontrak, d = dinas
            $table->string('status')->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jenis_jabatan');
    }
};
