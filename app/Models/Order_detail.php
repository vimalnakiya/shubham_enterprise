<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order_detail extends Model
{
    use HasFactory;

    function orders(){
        return $this->hasMany(Order::class);
    }

    function product(){
        return $this->belongsTo(Product::class);
    }
}
