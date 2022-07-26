<?php

namespace App\Models\dashboard\Courses;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class course extends Model
{
    use HasFactory;
    protected $table = 'courses';
    protected $fillable = ['image', 'promo_video', 'slug'];

    public function details()
    {
        return $this->hasMany(courseDetails::class, 'course_id', 'id');
    }

    public function points()
    {
        return $this->hasMany(coursePoints::class, 'course_id', 'id');
    }

    public function detailsApi($lang)
    {
        return $this->hasMany(courseDetails::class, 'course_id', 'id')->where('language', $lang)->get();
    }

    public function pointsApi($lang)
    {
        return $this->hasMany(coursePoints::class, 'course_id', 'id')->where('language', $lang)->get();
    }

    public function videos()
    {
        return $this->hasMany(courseVideos::class, 'course_id', 'id');
    }
}
