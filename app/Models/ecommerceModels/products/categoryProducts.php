<?php

namespace App\Models\ecommerceModels\products;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class categoryProducts extends Model
{
    use HasFactory;
    protected $table = 'category_products';
    protected $fillable = ['product_id', 'category_id'];
    public $timestamps = false;
}
