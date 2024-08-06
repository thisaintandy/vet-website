<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    use HasFactory;
    protected $fillable = [
        'product_name'.
        'product_price'.
        'product_description'.
        'product_image'.
        'no_available_products',
    ];

    protected $primaryKey = 'product_id';
}
