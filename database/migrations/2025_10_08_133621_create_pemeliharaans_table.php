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
    Schema::create('pemeliharaans', function (Blueprint $table) {
        $table->id();
        $table->foreignId('id_peralatan')->constrained('peralatans')->onDelete('cascade');
        $table->string('kondisi_awal', 20);
        $table->date('tanggal')->nullable();
        $table->string('jenis_pemeliharaan', 100)->nullable();
        $table->string('rekomendasi', 300)->nullable();
        $table->string('kerusakan', 300)->nullable();
        $table->string('pelaksana', 300)->nullable();
        $table->string('gambar', 100)->nullable();
        $table->string('laporan', 100)->nullable();
        $table->string('laporan2', 100)->nullable();
        $table->text('text_wa')->nullable();
        $table->string('catatan_pemeliharaan', 200)->nullable();
        $table->string('author', 5);
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pemeliharaans');
    }
};