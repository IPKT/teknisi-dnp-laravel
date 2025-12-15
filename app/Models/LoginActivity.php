<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoginActivity extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'ip_address',
        'user_agent',
    ];

    // Relasi balik ke User (Opsional, buat jaga-jaga kalau butuh data usernya)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}