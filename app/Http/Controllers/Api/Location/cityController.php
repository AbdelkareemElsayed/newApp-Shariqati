<?php

namespace App\Http\Controllers\Api\Location;

use App\Http\Controllers\Controller;
use App\Models\dashboard\location\cities;
use Illuminate\Http\Request;

class cityController extends Controller
{
    //
    #######################################################################################
    # Get Citties Based On State Id . . .
    public function Cities($state_id)
    {
        $data = cities::where('state_id', $state_id)->get();

        return response()->json(['data' => $data], 200);
    }
  #######################################################################################

}

