<?php

namespace App\Models\dashboard\items;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class items_second_level extends Model
{
    use HasFactory;

    protected $table = 'items_level_two';

    protected $fillable = ['title','content','admin_id','item_id'];




     # Relation with item table
        public function item()
        {
            return $this->belongsTo('App\Models\dashboard\items\items','item_id');
        }



}
