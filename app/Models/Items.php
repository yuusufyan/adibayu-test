<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Items extends Model
{
    //n
    protected $fillable = ['kode', 'nama', 'harga', 'image'];

}
