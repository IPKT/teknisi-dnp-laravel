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
        Schema::create('hardware', function (Blueprint $table) {
            $table->id();
            $table->string('jenis_hardware',100);
            $table->string('jenis_peralatan', 50);
            $table->year('tahun_masuk');
            $table->date('tanggal_masuk')->nullable();
            $table->string('merk',50);
            $table->string('tipe',50);
            $table->string('serial_number',100)->nullable();
            $table->string('status',50)->nullable();//ready, terpasang
            $table->string('sumber_pengadaan',100)->nullable();
            $table->date('tanggal_keluar')->nullable();
            $table->date('tanggal_dilepas')->nullable();
            $table->string('lokasi_pemasangan',100)->nullable()->constrained('peralatans')->onDelete('cascade');
            $table->string('lokasi_pengiriman',100)->nullable();
            $table->string('nomor_surat',100)->nullable();
            $table->string('keterangan',200)->nullable();
            $table->string('berkas',200)->nullable();
            $table->string('gambar',200)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hardware');
    }
};