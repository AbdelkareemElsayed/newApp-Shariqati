<?php

namespace App\Models\chat;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class conversationMessages extends Model
{
    use HasFactory;
    protected $table = "conversationmessages";
    protected $fillable = ["conversation_id" , "user_id", "type","message","time"];


  # Set accessors
  public function getTimeAttribute($value)
  {
      return date('d-m-Y h:i:s a',$value );
  }


    public $timestamps = false;
}
