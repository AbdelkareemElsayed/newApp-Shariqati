<?php

namespace App\Models;
use App\Models\dashboard\location\countries;
use App\Models\dashboard\location\cities;
use App\Models\dashboard\location\states;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class address extends Model
{
    use HasFactory;

    protected $table = "address";
    protected $fillable = ["country_id","state_id","city_id","fulladdress","location","is_default","user_id"];


    # Get Country Data . . . 
    public function GetCustomerCountry()
    {
        return $this->belongsTo(countries::class, 'country_id', 'id');
    }

    # Get Country Data . . . 
    public function GetCustomerStates()
    {
        return $this->belongsTo(states::class, 'state_id', 'id');
    }
    
    # Get Country Data . . . 
    public function GetCustomerCity()
    {
        return $this->belongsTo(cities::class, 'city_id', 'id');
    }


}
