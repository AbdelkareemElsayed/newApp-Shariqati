<?php

namespace App\Models\dashboard\blog;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class blogContent extends Model
{
    protected $table = 'blog_content';
    protected $fillable = ['title', 'content', 'language', 'blog_id'];
}
