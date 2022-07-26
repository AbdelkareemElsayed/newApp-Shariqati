<?php

namespace App\Models\dashboard\Data;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class data extends Model
{
    protected $table = 'data';
    protected $fillable = ['name'];
}
