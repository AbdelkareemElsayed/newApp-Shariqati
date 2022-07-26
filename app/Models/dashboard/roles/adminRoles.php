<?php

namespace App\Models\dashboard\roles;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\dashboard\roles\adminrolesTitles;
use App\Models\dashboard\Modules\modulesPermissions;

class adminRoles extends Model
{
    use HasFactory;

    protected $table = "adminroles";
    protected $fillable = ['permissions'];

    # Get Role  details . . . 
    public function roleData()
    {
        return $this->hasMany(adminrolesTitles::class, 'role_id', 'id')->where('lang',session()->get('lang'));
    }


    
    # Get Role  details full Lang . . . 
    public function roleDataGenralLang()
    {
        return $this->hasMany(adminrolesTitles::class, 'role_id', 'id');
    }

    # Get Permessions  details . . . 
    public function permissions()
    {
        return $this->hasMany(modulesPermissions::class, 'role_id', 'id');
    }




    
}
