<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peralatan extends Model
{
    use HasFactory;

    public function pemeliharaans()
    {
        return $this->hasMany(Pemeliharaan::class, 'id_peralatan');
    }

    public function hardwares()
    {
        return $this->hasMany(Hardware::class, 'lokasi_pemasangan');
    }

    public function dokumens()
    {
        return $this->hasMany(Dokumen::class, 'id_peralatan');
    }


    protected $fillable = [
        'kode',
        'kondisi_terkini',
        'jenis',
        'kelompok',
        'koordinat',
        'lokasi',
        'detail_lokasi',
        // 'tipe',
        'nama_pic',
        'jabatan_pic',
        'kontak_pic',
        'catatan'
    ];
}