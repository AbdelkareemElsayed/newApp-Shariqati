<?php

namespace App\Models\dashboard\location;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\dashboard\location\cities;

class states extends Model
{
    use HasFactory;
    protected $fillable = ['name','name_ar','country_id'];



     # FETCH STATE DATA RELATION . . .
     function Cities(){

        return $this->hasMany(cities :: class , 'state_id','id');
     }


}