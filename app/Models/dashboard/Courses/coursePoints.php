<?php

namespace App\Models\dashboard\Courses;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class coursePoints extends Model
{
    use HasFactory;
    protected $table = 'course_points';
    protected $fillable = ['course_id', 'lang_id', 'point', 'language'];
}
