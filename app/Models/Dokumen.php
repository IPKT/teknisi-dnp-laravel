<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Dokumen extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'id_peralatan',
        'tanggal_dokumen',
        'nama_dokumen',
        'file_dokumen',
        'keterangan_dokumen',
        'author'
    ];

        public function peralatan()
    {
        return $this->belongsTo(Peralatan::class, 'id_peralatan');
    }
}