<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sales extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode',
        'user_id',
        'tanggal',
        'total_harga',
        'status',
    ];

    // Relasi ke user (kasir)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke detail item
    public function items()
    {
        return $this->hasMany(SalesItem::class);
    }
}
