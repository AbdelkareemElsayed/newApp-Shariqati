<?php

namespace App\Models\ecommerceModels\products;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class productImage extends Model
{
    use HasFactory;
    protected $table = 'product_images';
    protected $fillable = ['product_id', 'path'];
}
