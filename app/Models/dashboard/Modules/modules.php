<?php

namespace App\Models\dashboard\Modules;
use App\Models\dashboard\Modules\modulesPermissions;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class modules extends Model
{
    use HasFactory;

    protected $table = 'modules';
    protected $fillable = ['title_ar','title_en','icon'];
    public $timestamps = false;

    # permissions Relation 
    public function permissions()
    {
        return $this->hasOne(modulesPermissions::class, 'module_id', 'id');
    }
}
