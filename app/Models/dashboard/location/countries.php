<?php

namespace App\Models\dashboard\location;

use App\Models\dashboard\location\states;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class countries extends Model
{
    use HasFactory;

    protected $fillable = ['name','name_ar'];

     # FETCH STATE DATA RELATION . . .
     function States(){

        return $this->hasMany(states :: class , 'country_id','id');
     }


}
