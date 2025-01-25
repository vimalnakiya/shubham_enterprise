<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    function brand(){
        return $this->belongsTo(Brand::class);
    }
    function category(){
        return $this->belongsTo(Category::class);
    }

    function order_details(){
        return $this->hasMany(Order_detail::class);
    }
}
