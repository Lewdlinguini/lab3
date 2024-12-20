<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['product_name', 'description', 'price', 'discounted_price', 'stock', 'image', 'discount', 'genre'];


    public function category()
    {
        return $this->belongsTo(Category::class);
    }

}

