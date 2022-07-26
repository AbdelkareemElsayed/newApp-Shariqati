<?php

namespace App\Models\dashboard\contactUs;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class contactUs extends Model
{
    use HasFactory;
    protected $table    = 'contactus';
    protected $fillable = ['name','email','message'];
}
