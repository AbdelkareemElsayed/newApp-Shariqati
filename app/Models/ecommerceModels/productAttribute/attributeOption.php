<?php

namespace App\Models\ecommerceModels\productAttribute;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class attributeOption extends Model
{
    use HasFactory;
    protected $table = 'attribute_option';
    protected $fillable = ['attribute_id'];

    public function value()
    {
        return $this->hasMany(attributeOptionDescription::class, 'option_id', 'id');
    }
}
