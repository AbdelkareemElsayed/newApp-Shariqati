<?php

namespace App\Models\dashboard\TeamMembers;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class member extends Model
{
    protected $table = 'team_members';
    protected $fillable = ['name_ar', 'name_en', 'about_ar', 'about_en', 'image', 'facebook_link', 'twitter_link', 'linkedin_link', 'youtube_link'];
}
