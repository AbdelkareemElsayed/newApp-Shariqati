<?php

namespace App\Http\Controllers\Api\Location;

use App\Http\Controllers\Controller;
use App\Models\dashboard\location\countries;
use Illuminate\Http\Request;

class countryController extends Controller
{

    #######################################################################################
    public function Countries()
    {
        $data = countries::get(['id','name_ar','name']);

        return response()->json(['data' => $data], 200);
    }
    #######################################################################################
  
}
