<?php

namespace App\Http\Controllers\Api\contctUs;

use App\Http\Controllers\Controller;
use App\Models\dashboard\contactUs\contactUs;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class contctUsController extends Controller
{


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3',
            'email' => 'required|email',
            'message' => 'required|min:20',

        ]);

        if ($validator->fails()) {
            return response()->json(['fail' => __('admin.validation_error'), 'data' => $validator->messages()], 400);
        }

        # FETCH REQUEST DATA . . .
        $data = $request->all();


        $op =  contactUs::create($data);

        if ($op) {
            $returned = ["Sussess" => "Raw Inserted", 'code' => 201];
        } else {

            $returned = ["Error" => "Error Try Again", 'code' => 500];
        }

        return response()->json($returned, 200);
    }
}
