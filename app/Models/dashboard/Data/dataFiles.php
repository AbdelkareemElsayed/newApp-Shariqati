<?php

namespace App\Models\dashboard\Data;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class dataFiles extends Model
{
    protected $table = 'data_files';
    protected $fillable = ['data_id', 'name', 'file'];
}
