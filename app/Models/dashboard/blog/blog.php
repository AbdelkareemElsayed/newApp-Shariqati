<?php

namespace App\Models\dashboard\blog;

use App\Models\dashboard\General\keyword;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class blog extends Model
{
    protected $table = 'blogs';
    protected $fillable = ['image', 'slug', 'date', 'category_id'];

    public function content()
    {
        return $this->hasMany(blogContent::class, 'blog_id', 'id')->whereIn('language', languages());
    }

    public function keywords()
    {
        return $this->hasMany(keyword::class, 'item_id', 'id')->where('flag', 1);
    }
}
