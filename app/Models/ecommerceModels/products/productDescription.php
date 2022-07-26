<?php

namespace App\Models\ecommerceModels\products;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class productDescription extends Model
{
    use HasFactory;
    protected $table = 'products_content';
    protected $fillable = ['title', 'content', 'product_id', 'language'];
}
