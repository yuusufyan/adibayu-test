<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'sale_id',
        'item_id',
        'qty',
        'harga_satuan',
        'total',
    ];

    public function sale()
    {
        return $this->belongsTo(Sales::class);
    }

    public function item()
    {
        return $this->belongsTo(Items::class);
    }
}
