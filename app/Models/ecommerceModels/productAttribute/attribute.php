<?php

namespace App\Models\ecommerceModels\productAttribute;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class attribute extends Model
{
    use HasFactory;
    protected $table = 'attributes';

    public function description()
    {
        return $this->hasMany(attributeDescription::class, 'attribute_id', 'id');
    }

    public function options()
    {
        return $this->hasMany(attributeOption::class, 'attribute_id', 'id');
    }
}
