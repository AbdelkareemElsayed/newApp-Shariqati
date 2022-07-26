<?php

namespace App\Models\chat;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class conversation extends Model
{
    use HasFactory;

    protected $table = "conversation";
    protected $fillable = ["user_id",'time'];

    public $timestamps = false;


  # Set accessors
  public function getTimeAttribute($value)
  {
      return date('d-m-Y h:i:s a',$value );
  }


    public function messages()
    {
        return $this->hasMany(conversationMessages :: class , 'conversation_id');
    }
}
