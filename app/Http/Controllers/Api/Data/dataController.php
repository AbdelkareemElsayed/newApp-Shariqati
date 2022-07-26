<?php

namespace App\Http\Controllers\Api\Data;

use App\Http\Controllers\Controller;
use App\Models\dashboard\Data\data;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class dataController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = data::orderBy('id', 'desc')->get();
        return response()->json(['success' => __('admin.data_fetched'), 'data' => $data], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = Validator::make($request->all(), [
            'name' => 'required',
        ]);

        if ($data->fails()) {
            return response()->json(['error' => __('admin.validation_error'), 'data' => $data->messages()], 400);
        }

        $data = $request->all();

        $add_op_faild     = trans('admin.add_op_faild');
        $add_op_succ      = trans('admin.add_op_succ');
        $add = data::create($data);

        if ($add) {
            # Log to database
            $userType = 1;
            $log = logCreated($userType, auth('api')->user()->id, 'Data', 'New Data Files Added', json_encode($add));

            return response()->json(['success' => $add_op_succ], 200);
        } else {
            return response()->json(['error_message' => $add_op_faild], 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = Validator::make($request->all(), [
            'name' => 'required',
        ]);

        if ($data->fails()) {
            return response()->json(['error' => __('admin.validation_error'), 'data' => $data->messages()], 400);
        }

        $data = $request->all();
        $oldData = data::find($id);

        $updated = data::where('id', $id)->update($data);

        if ($updated) {
            # Log to database
            $userType = 1;
            $log = logUpdated($userType, auth('api')->user()->id, 'Data', 'Data Folder has been updated', json_encode($data), json_encode($oldData));

            return response()->json(['message' => trans('admin.updated_record')], 200);
        } else {
            return response()->json(['error_message' => trans('admin.updated_record_error')], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = data::find($id);
        $deleted = data::find($id)->delete();
        $succ_op   = trans('admin.del.op_succ');
        $failed_op = trans('admin.del.op_faild');

        if ($deleted) {
            # Log to database
            $userType = 1;
            $log = logDeleted($userType, auth('api')->user()->id, 'Data', 'Data Folder has been deleted', json_encode($data));

            return response()->json(['message' => $succ_op], 200);
        } else {
            return response()->json(['error_message', $failed_op], 400);
        }
    }
}
