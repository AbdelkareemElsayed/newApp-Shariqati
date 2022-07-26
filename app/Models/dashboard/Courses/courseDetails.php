<?php

namespace App\Models\dashboard\Courses;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class courseDetails extends Model
{
    use HasFactory;
    protected $table = 'course_details';
    protected $fillable = ['course_id', 'language', 'title', 'description'];
}
