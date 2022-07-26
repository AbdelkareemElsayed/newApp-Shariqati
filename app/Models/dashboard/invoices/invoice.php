<?php

namespace App\Models\dashboard\invoices;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class invoice extends Model
{
    use HasFactory;


    protected $table = 'invoices';

    protected $fillable = ['user_id','admin_id','item_id','price','quantity','total','invoice_type', 'discount_value','discount_type','time','discount_value' , 'discount_type','branch_id'];

    public $timestamps = false;

    # Items Relation . . .
     public function items(){
        return $this->belongsTo('App\Models\dashboard\items\items', 'item_id');
    }

    # User Relation . . .
     public function userDetails(){
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    # Admin Relation . . .
     public function adminDetails(){
        return $this->belongsTo('App\Models\dashboard\admins\admin', 'admin_id');
    }

    # Branch Relation . . .
     public function branchDetails(){
        return $this->belongsTo('App\Models\dashboard\Branches\branch', 'branch_id');
    }
    



}
