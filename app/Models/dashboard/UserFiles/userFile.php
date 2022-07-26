<?php

namespace App\Models\dashboard\UserFiles;

use Illuminate\Database\Eloquent\Model;

class userFile extends Model
{
    protected $table = 'user_files';
    protected $fillable = ['user_id', 'title', 'file'];
}
