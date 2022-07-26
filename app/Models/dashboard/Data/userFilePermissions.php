<?php

namespace App\Models\dashboard\Data;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class userFilePermissions extends Model
{
    public $timestamps = false;
    protected $table = 'user_file_permissions';
    protected $fillable = ['user_id', 'file_id'];
}
