<?php

namespace App\Models\dashboard\Data;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class accessRequests extends Model
{
    protected $table = 'access_requests';
    protected $fillable = ['user_id', 'file_id', 'status'];

    public function requestUser()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function requestFile()
    {
        return $this->hasOne(dataFiles::class, 'id', 'file_id');
    }
}
