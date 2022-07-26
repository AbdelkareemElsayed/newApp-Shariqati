<?php

namespace App\Models\ecommerceModels\productAttribute;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class attributeOptionDescription extends Model
{
    use HasFactory;
    protected $table = 'attribute_option_descriptions';
    protected $fillable = ['option_id', 'name', 'language'];
}
