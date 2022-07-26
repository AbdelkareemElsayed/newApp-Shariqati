<?php

namespace App\Models\ecommerceModels\products;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ecommerceModels\products\productsFlashsale;

class product extends Model
{
    use HasFactory;
    protected $table = 'products';
    protected $fillable = ['slug', 'price', 'manufacturers_id', 'quantity', 'image', 'products_status', 'is_feature','isFlashe', 'min_order', 'max_order', 'addedby', 'category_id'];

    public function content()
    {
        return $this->hasMany(productDescription::class, 'product_id', 'id');
    }


     public function flashsale(){
        return $this->hasOne(productsFlashsale::class, 'product_id', 'id');
     }


}
