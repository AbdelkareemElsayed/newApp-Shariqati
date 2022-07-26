<?php

namespace App\Models\dashboard\Events;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class eventDetails extends Model
{
    protected $table = 'event_details';
    protected $fillable = ['event_id', 'name', 'details', 'points', 'language'];
}
