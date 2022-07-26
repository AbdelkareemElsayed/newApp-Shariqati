<?php

namespace App\Models\dashboard\staticpages;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class staticPagesKeys extends Model
{
    use HasFactory;
    protected $table = 'staticpageskeys';
    protected $fillable = ['key', 'page_id'];
    protected $hidden = [ 'created_at' , 'updated_at','page_id'];

}
