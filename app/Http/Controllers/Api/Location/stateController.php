<?php

namespace App\Http\Controllers\Api\Location;

use App\Http\Controllers\Controller;
use App\Models\dashboard\location\states;
use Illuminate\Http\Request;

class stateController extends Controller
{

    #######################################################################################

    # Load State Based On Country Id  . . . 
    public function States($id)
    {

        $data = states::where('country_id', $id)->get();

        return response()->json(['data' => $data], 200);
    }
    #######################################################################################


}
