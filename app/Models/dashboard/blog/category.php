<?php

namespace App\Models\dashboard\blog;

use Illuminate\Database\Eloquent\Model;

class category extends Model
{
    protected $table = 'categories';
    protected $fillable = [
        'slug',
        'image',
    ];


    function description()
    {
        return $this->hasMany(categoryDescription::class, 'category_id', 'id')->whereIn('language', languages());
    }
}
