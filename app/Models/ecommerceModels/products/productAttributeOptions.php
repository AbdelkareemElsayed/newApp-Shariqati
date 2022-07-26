<?php

namespace App\Models\ecommerceModels\products;

use App\Models\ecommerceModels\productAttribute\attributeOption;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class productAttributeOptions extends Model
{
    use HasFactory;
    protected $table = 'product_attributes_options';
    protected $fillable = ['product_id', 'attribute_id', 'option_id', 'price'];
    public $timestamps = false;

    public function details()
    {
        return $this->hasOne(attributeOption::class, 'id', 'option_id');
    }
}
