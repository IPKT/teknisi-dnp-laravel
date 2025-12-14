<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Hardware extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'jenis_hardware',
        'jenis_peralatan',
        'tahun_masuk',
        'tanggal_masuk',
        'merk',
        'tipe',
        'serial_number',
        'status',
        'sumber_pengadaan',
        'tanggal_keluar',
        'tanggal_dilepas',
        'lokasi_pemasangan',
        'lokasi_pengiriman',
        'nomor_surat',
        'nomor_surat_keluar',
        'keterangan',
        'berkas',
        'gambar'
    ];

    public function peralatan()
    {
        return $this->belongsTo(Peralatan::class, 'lokasi_pemasangan');
    }
}