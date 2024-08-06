<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductsInCart extends Model
{
    use HasFactory;

    protected $table = 'products_in_cart';

    protected $fillable = [
        'product_name',
        'product_price',
        'product_description',
        'product_image',
        'product_quantity',
    ];

    protected $primaryKey = 'product_id';
}
