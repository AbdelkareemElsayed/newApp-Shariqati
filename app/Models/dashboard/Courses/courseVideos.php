<?php

namespace App\Models\dashboard\Courses;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class courseVideos extends Model
{
    protected $table = 'course_videos';
    protected $fillable = ['course_id', 'title_ar', 'title_en', 'video'];
}
