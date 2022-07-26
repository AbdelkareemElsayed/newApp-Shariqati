<?php

namespace App\Models\dashboard\location;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class cities extends Model
{
    use HasFactory;
    protected $fillable = ['name','name_ar','state_id','country_id'];

}
