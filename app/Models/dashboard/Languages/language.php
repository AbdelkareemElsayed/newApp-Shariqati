<?php

namespace App\Models\dashboard\Languages;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class language extends Model
{
    public $timestamps = false;
    protected $table = 'languages';
    protected $fillable = ['name', 'code', 'icon'];
}
