<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pemeliharaan extends Model
{
    use HasFactory;
  

    protected $fillable = [
        'id_peralatan',
        'kondisi_awal',
        'tanggal',
        'jenis_pemeliharaan',
        'rekomendasi',
        'kerusakan',
        'pelaksana',
        'gambar',
        'laporan',
        'laporan2',
        'text_wa',
        'catatan_pemeliharaan',
        'author'
    ];

    public function peralatan()
    {
        return $this->belongsTo(Peralatan::class, 'id_peralatan');
    }
}