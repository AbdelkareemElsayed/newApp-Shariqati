<?php

namespace App\Models\dashboard\admins;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\dashboard\roles\adminRoles;
use Illuminate\Foundation\Auth\User as Authenticatable;


class admin extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
           'name',
           'email',
           'password',
           'image', 
           'phone',
           'role_id'
    ];


      # Get Role  details . . . 
      public function role()
      {
          return $this->belongsTo(adminRoles::class, 'role_id', 'id');
      }
}
