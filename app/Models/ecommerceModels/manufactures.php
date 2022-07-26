<?php

namespace App\Models\ecommerceModels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class manufactures extends Model
{
    use HasFactory;

    protected $table = "manufacturers";
    protected $fillable = ["name","image","slug"];

}
