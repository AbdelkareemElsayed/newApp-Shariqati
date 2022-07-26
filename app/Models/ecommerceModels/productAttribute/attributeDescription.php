<?php

namespace App\Models\ecommerceModels\productAttribute;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class attributeDescription extends Model
{
    use HasFactory;
    protected $table = 'attribute_description';
    protected $fillable = ['name', 'language', 'attribute_id'];
}
