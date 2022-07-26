<?php

namespace App\Models\dashboard\roles;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class adminrolesTitles extends Model
{
    use HasFactory;

    protected $table     = "adminrolescontent"; 
    protected $fillable  = ["title","lang","role_id"];
    public    $timestamps = false; 
}
