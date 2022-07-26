<?php

namespace App\Models\dashboard\staticpages;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class staticPagesContent extends Model
{
    use HasFactory;
    protected $table = 'staticpagescontent';
    protected $fillable = ['title', 'content', 'lang','page_id'];
    protected $hidden = [ 'created_at' , 'updated_at','page_id'];

}
