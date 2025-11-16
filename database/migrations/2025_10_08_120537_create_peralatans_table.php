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
        Schema::create('peralatans', function (Blueprint $table) {
            $table->id();
            $table->string('kode', 50);
            $table->string('kondisi_terkini', 10)->default('ON');
            $table->string('koordinat', 50);
            $table->string('lokasi', 50);
            $table->string('detail_lokasi', 200)->nullable();
            $table->string('jenis', 100);
            $table->string('kelompok', 50)->default('aloptama');
            $table->string('nama_pic', 100)->nullable();
            $table->string('jabatan_pic', 100)->nullable();
            $table->string('kontak_pic', 20)->nullable();
            $table->string('catatan', 500)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peralatans');
    }
};