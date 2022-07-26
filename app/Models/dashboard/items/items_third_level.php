<?php

namespace App\Models\dashboard\items;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class items_third_level extends Model
{
    use HasFactory;

    protected $table = 'items_level_three';

    protected $fillable = ['title','content','admin_id','items_level_two'];



     # Relation with item_level_two table
        public function item_level_two()
        {
            return $this->belongsTo('App\Models\dashboard\items\items_second_level','items_level_two');
        }


}
