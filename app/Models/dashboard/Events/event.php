<?php

namespace App\Models\dashboard\Events;

use App\Models\dashboard\General\keyword;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class event extends Model
{
    protected $table = 'events';
    protected $fillable = ['from', 'to', 'slug', 'image', 'time_from', 'time_to', 'points'];


    function eventDetails()
    {
        return $this->hasMany(eventDetails::class, 'event_id', 'id')->whereIn('language', languages());
    }

    function eventDetail($lang)
    {
        return $this->hasOne(eventDetails::class, 'event_id', 'id')->where('language', $lang)->get();
    }

    public function keywords()
    {
        return $this->hasMany(keyword::class, 'item_id', 'id')->where('flag', 2);
    }
}
