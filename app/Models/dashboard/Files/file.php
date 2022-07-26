<?php

namespace App\Models\dashboard\Files;

use App\Models\dashboard\admins\admin;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class file extends Model
{
    use HasFactory;

    protected $table = "files";
    protected $fillable = ['user_id', 'name'];


    # Create Relation With Model . . .

    public function uploadedBy()
    {
        return $this->belongsTo(admin::class, 'user_id', 'id');
    }
}
