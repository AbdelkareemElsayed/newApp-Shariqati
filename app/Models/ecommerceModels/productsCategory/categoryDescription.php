<?php

namespace App\Models\ecommerceModels\productsCategory;

use Illuminate\Database\Eloquent\Model;

class categoryDescription extends Model
{
    protected $table = 'product_category_description';
    protected $fillable = [
        'name',
        'description',
        'language',
        'category_id'
    ];
}
