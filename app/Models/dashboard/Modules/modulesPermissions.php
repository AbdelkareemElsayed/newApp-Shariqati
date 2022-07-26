<?php

namespace App\Models\dashboard\Modules;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\dashboard\Modules\modules;


class modulesPermissions extends Model
{
    use HasFactory;

    protected $table = 'modulespermissions';
    protected $fillable = ['role_id','module_id', 'is_show', 'is_create', 'is_update', 'is_delete'];
    public $timestamps = false;


    public function setisShowAttribute($value)
    {
        $this->attributes['is_show'] =($value == 'on')?1:0;
    }

    public function setisCreateAttribute($value)
    {
        $this->attributes['is_create'] =($value == 'on')?1:0;
    }

    public function setisUpdateAttribute($value)
    {
        $this->attributes['is_update'] =($value == 'on')?1:0;
    }

    public function setisDeleteAttribute($value)
    {
        $this->attributes['is_delete'] =($value == 'on')?1:0;
    }



     # Module Relation 
     public function module()
     {
         return $this->belongsTo(modules::class, 'module_id', 'id');
     }

}
