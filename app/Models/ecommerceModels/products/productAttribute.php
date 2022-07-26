<?php

namespace App\Models\ecommerceModels\products;

use App\Models\ecommerceModels\productAttribute\attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class productAttribute extends Model
{
    use HasFactory;
    protected $table = 'product_attributes';
    protected $fillable = ['product_id', 'attribute_id'];
    public $timestamps = false;

    public function attribute()
    {
        return $this->hasOne(attribute::class, 'id', 'attribute_id');
    }
}
