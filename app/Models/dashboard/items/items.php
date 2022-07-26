<?php

namespace App\Models\dashboard\items;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class items extends Model
{
    use HasFactory;

    protected $table = 'items';

    protected $fillable = ['title','content','admin_id'];

}
