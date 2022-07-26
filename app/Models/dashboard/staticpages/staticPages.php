<?php

namespace App\Models\dashboard\staticpages;
use App\Models\dashboard\staticpages\staticPagesContent;
use App\Models\dashboard\staticpages\staticPageskeys;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class staticPages extends Model
{
    use HasFactory;

    private $lang = "en"; 

    protected $table = 'staticpages';
    protected $fillable = ['image', 'slug', 'tag_title'];
    protected $hidden = [ 'created_at' , 'updated_at'];
    

    public function content()
    {
        return $this->hasMany(staticPagesContent::class, 'page_id', 'id')->where('lang',$this->lang);
    }


    public function keywords()
    {
        return $this->hasMany(staticPageskeys::class, 'page_id', 'id');
    }

}