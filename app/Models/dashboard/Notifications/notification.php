<?php

namespace App\Models\dashboard\Notifications;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class notification extends Model
{
    protected $table = 'notifications';
    protected $fillable = ['user_id', 'title', 'content', 'title_ar', 'content_ar'];
}
