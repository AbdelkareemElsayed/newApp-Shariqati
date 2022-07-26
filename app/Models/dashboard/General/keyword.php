<?php

namespace App\Models\dashboard\General;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class keyword extends Model
{
    public $timestamps = false;
    protected $table = 'keywords';
    protected $fillable = ['item_id', 'keyword', 'flag'];
}
