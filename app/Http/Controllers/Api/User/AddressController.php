<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Models\address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class AddressController extends Controller
{
    //

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['']]);
    }

    ##################################################################################################################
    public function index()
    {

        $data = address::where('user_id', auth('api')->user()->id)->get();

        return response()->json(['data' => $data], 200);
    }

    ##################################################################################################################

    public function store(Request $request)
    {

        $validator =  Validator::make($request->all(), [
            "fulladdress" => "required",
            "location"    => "required|url",
            "country_id"  => "required:numeric",
            "state_id"    => "required:numeric",
            "city_id"     => "required:numeric",
        ]);


        if ($validator->fails()) {
            return response()->json(['Message' =>  $validator->messages()], 400);
        } else {

            $data = $request->all();
            # Append Customer id
            $data['user_id'] =  auth('api')->user()->id;

            # Insert Data . . . 
            $op =  address::create($data);


            if ($op) {
                # Log to database
                $userType = 2;
                $log = logCreated($userType, auth('api')->user()->id, 'customerAddress', 'New Address Added', json_encode($data));

                $returned = ["Sussess" => "Raw Inserted", 'code' => 201];
            } else {

                $returned = ["Error" => "Error Try Again", 'code' => 500];
            }

            return response()->json($returned, 200);
        }
    }

    ##################################################################################################################
    public function update(Request $request, $id)
    {

        $validator =  Validator::make($request->all(), [
            "fulladdress" => "required",
            "location"    => "required|url",
            "country_id"  => "required:numeric",
            "state_id"    => "required:numeric",
            "city_id"     => "required:numeric",
        ]);


        if ($validator->fails()) {
            return response()->json(['Message' =>  $validator->messages()], 400);
        } else {
            $oldData = address::where(['user_id' => auth('api')->user()->id, 'id' => $id])->get()[0];

            $data = $request->all();

            # Append Customer id
            $data['user_id'] =  auth('api')->user()->id;

            # Insert Data . . . 
            $op =  address::where(['user_id' => auth('api')->user()->id, 'id' => $id])->update($data);


            if ($op) {
                # Log to database
                $userType = 2;
                $log = logUpdated($userType, auth('api')->user()->id, 'customerAddress', 'Address has been updated', json_encode($data), json_encode($oldData));

                $returned = ["Sussess" => "Raw Updated", 'code' => 200];
            } else {

                $returned = ["Error" => "Error Try Again", 'code' => 500];
            }

            return response()->json($returned, 200);
        }
    }

    #######################################################################################################################
    public function show($id)
    {
        $data = address::where([['user_id' => auth('api')->user()->id], ['id' => $id]])->get();

        return response()->json(['data' => $data], 200);
    }
    ##################################################################################################################


    public function destroy(Request $request, $id)
    {
        $data = address::where(['user_id' => auth('api')->user()->id, 'id' => $id])->get()[0];
        $op = address::where(['user_id' => auth('api')->user()->id, 'id' => $id])->delete();

        if ($op) {
            # Log to database
            $userType = 2;
            $log = logDeleted($userType, auth('api')->user()->id, 'customerAdress', 'Address has been deleted', json_encode($data));

            $message = "Address Deleted Successfully";
            $code = 200;
        } else {
            $message = "Can't do This Action";
            $code = 401;
        }
        return response()->json(['data' => $message, 'code' => $code], 200);
    }

    ##################################################################################################################

    public function MakeAddressDefault($id)
    {
        # Set All User Address Normal . . .
        address::where('user_id', auth('api')->user()->id)->update(['is_default' => 0]);

        # Set Address with (id) is Default . . .
        $op = address::where(['user_id' => auth('api')->user()->id, 'id' => $id])->update(['is_default' => 1]);

        if ($op) {
            $message = "Address Changed To Default Successfully";
            $code = 200;
        } else {
            $message = "Can't do This Action";
            $code = 401;
        }
        return response()->json(['data' => $message, 'code' => $code], 200);
    }
}
