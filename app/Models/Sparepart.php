<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Sparepart extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'jenis_barang',
        'jenis_peralatan',
        'tahun_masuk',
        'tanggal_masuk',
        'merk',
        'tipe',
        'serial_number',
        'status',
        'sumber_pengadaan',
        'tanggal_keluar',
        'lokasi_pemasangan',
        'lokasi_pengiriman',
        'keterangan',
        'berkas',
        'berkas2'
    ];

    public function peralatan()
    {
        return $this->belongsTo(Peralatan::class, 'lokasi_pemasangan');
    }
}