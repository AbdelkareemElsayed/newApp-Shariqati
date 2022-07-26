<?php

namespace App\Models\dashboard\blog;

use Illuminate\Database\Eloquent\Model;

class categoryDescription extends Model
{
    protected $table = 'category_description';
    protected $fillable = [
        'name',
        'description',
        'language',
        'category_id'
    ];
}
