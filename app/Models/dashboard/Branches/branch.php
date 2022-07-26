<?php

namespace App\Models\dashboard\Branches;

use App\Models\dashboard\location\cities;
use App\Models\dashboard\location\countries;
use App\Models\dashboard\location\states;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class branch extends Model
{
    use HasFactory;

    protected $table = "branches";
    protected $fillable = [
        "name_en",
        "name_ar",
        "email",
        "location",
        "facebook",
        "whatsapp",
        "instagram",
        "linkedin",
        "twitter",
        "tiktok",
        "snapchat",
        "country_id",
        "state_id",
        "city_id",
        "streetName",
        "buildNumber",
        "commomPlaces",
        "address_additional",
        "phone",
        "company_id"
    ];



    # Get Country Data . . .
    public function GetCountry()
    {
        return $this->belongsTo(countries::class, 'country_id', 'id');
    }


    # Get state Data . . .
    public function Getstate()
    {
        return $this->belongsTo(states::class, 'state_id', 'id');
    }

    # Get city Data . . .
    public function GetCity()
    {
        return $this->belongsTo(cities::class, 'city_id', 'id');
    }
}
