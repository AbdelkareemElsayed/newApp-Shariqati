<?php

namespace App\Models\ecommerceModels\productsCategory;

use App\Models\ecommerceModels\products\categoryProducts;
use App\Models\ecommerceModels\products\product;
use Illuminate\Database\Eloquent\Model;
use App\Models\ecommerceModels\productsCategory\categoryDescription;

class category extends Model
{
    protected $table = 'product_categories';
    protected $fillable = [
        'slug',
        'image',
        'parent_id'
    ];


    function description()
    {
        return $this->hasMany(categoryDescription::class, 'category_id', 'id')->whereIn('language', languages());
    }

    public function childCategories()
    {
        return $this->hasMany(category::class, 'parent_id');
    }

    public function subCategories()
    {
        return $this->hasMany(category::class, 'parent_id')->with('childCategories');
    }

    public function products()
    {
        return $this->hasManyThrough(product::class, categoryProducts::class, 'category_id', 'id', 'id', 'product_id');
    }
}
