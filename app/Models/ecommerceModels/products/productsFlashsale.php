<?php

namespace App\Models\ecommerceModels\products;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class productsFlashsale extends Model
{
    use HasFactory;

    protected $table = 'productsflashsale';

    protected $fillable = ['product_id','value','start','end'];


    // mutator start
    public function setStartAttribute($value)
    {
        $this->attributes['start'] = strtotime($value);
    }

    // mutator end
    public function setEndAttribute($value)
    {
        $this->attributes['end'] = strtotime($value);
    }





}
