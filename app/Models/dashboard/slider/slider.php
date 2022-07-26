<?php

namespace App\Models\dashboard\slider;

use Illuminate\Database\Eloquent\Model;

class slider extends Model
{
    protected $table = 'slides';
    protected $fillable = ['image', 'title', 'alt_text'];
}
