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
        Schema::create('pertanyaan', function (Blueprint $table) {
            $table->id();

            $table->foreignId('kategori_laporan_id')
                ->constrained('kategori_laporan')
                ->onDelete('cascade');

            $table->foreignId('jenis_laporan_id')
                ->constrained('jenis_laporan')
                ->onDelete('cascade');

            $table->string('pertanyaan');
            $table->string('status')->default('active');
        
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pertanyaan');
    }
};
