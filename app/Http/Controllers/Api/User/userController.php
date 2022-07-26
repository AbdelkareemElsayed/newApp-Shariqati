<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Upload;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class userController extends Controller
{
    //

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['Register']]);
    }

    public function Register(Request $request)
    {

        $validator =  Validator::make($request->all(), [
            'name'        => "required|min:2",
            'email'       => "required|email|unique:users",
            'password'    => "required|min:6|max:10",
            "image"       => "required|image|mimes:png,jpg,jpeg",
            "phone"       => "required",
            "country_id"  => "required|numeric"
        ]);


        if ($validator->fails()) {
            return response()->json(['Message' =>  $validator->messages()], 400);
        } else {
            // code . . .

            # Get All Request Data . . .
            $data = $request->all();

            # Hash Password . . .
            $data['password'] = bcrypt(request('password'));

            # Upload Image . . . .
            $data['image'] = Upload::upload([
                'file'        => 'image',
                'path'        => 'CustomersAccount',
                'upload_type' => 'single',
                'delete_file' => '',
            ]);

            # Insert data . . .
            $op               =  User::create($data);

            if ($op) {
                loggers(2, $op->id, Request()->ip(), 3);
                $returned = ["Sussess" => "Raw Inserted", 'code' => 201];
            } else {

                $returned = ["Error" => "Error Try Again", 'code' => 500];
            }

            return response()->json($returned, 200);
        }
    }

    ####################################################################################################################

    public function  UserDetails()
    {

        $data   =  User::where('id', auth('api')->user()->id)->with('GetCustomerCountry')->get()->map(function (User $user) {
            $user->image = asset('storage/' . $user->image);
            return $user;
        });

        return response()->json(['data' => $data], 200);
    }

    ####################################################################################################################


    public function UpdateAccount(Request $request)
    {

        $validator =  Validator::make($request->all(), [
            'name'        => "required|min:2",
            'email'       => "required|email|unique:users,email," . auth('api')->user()->id,
            "image"       => "nullable|image|mimes:png,jpg,jpeg",
            "phone"       => "required",
            "country_id"  => "required|numeric"
        ]);


        if ($validator->fails()) {
            return response()->json(['Message' =>  $validator->messages()], 400);
        } else {
            // code . . .

            # Get All Request Data . . .
            $data = $request->all();

            # Check If Request Has New Image || Not . . .
            if (request()->hasFile('image')) {
                $data['image'] = Upload::upload([
                    'file'        => 'image',
                    'path'        => 'CustomersAccount',
                    'upload_type' => 'single',
                    'delete_file' => User::find(auth('api')->user()->id)->image,
                ]);
            }

            $op = User::find(auth('api')->user()->id)->update($data);

            if ($op) {
                $returned = ["Sussess" => "Raw Updated", 'code' => 200];
            } else {

                $returned = ["Error" => "Error Try Again", 'code' => 500];
            }

            return response()->json($returned, 200);
        }
    }
    ####################################################################################################################

    public function updatePassword(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'new_password'     => 'required|min:6',
            'current_password' => "required|min:6|current_password:api"
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' =>  $validator->messages()], 400);
        } else {


            if (Hash::check($request->current_password, auth('api')->user()->password)) {

                $password = bcrypt($request->new_password);

                $op =  User::find(auth('api')->user()->id)->update(['password' => $password]);

                if ($op) {
                    $returned = ["Sussess" => "Password Updated", 'code' => 200];
                } else {

                    $returned = ["Error" => "Error Try Again", 'code' => 500];
                }

                return response()->json($returned, 200);
            } else {
                return response()->json(['errors' =>  'Unauthorized'], 200);
            }
        }
        ####################################################################################################################

    }
}
