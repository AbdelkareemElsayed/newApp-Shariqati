<?php

namespace App\Http\Controllers\Api\Data;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Upload;
use App\Models\dashboard\Data\dataFiles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class dataFilesController extends Controller
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
    public function index($id)
    {
        $data = dataFiles::where('data_id', $id)->orderBy('id', 'desc')->get();
        $data = $data->map(function ($item) {
            $file['id'] = $item->id;
            $file['name'] = $item->name;
            $file['file'] = $item->file;
            $file['permitted'] = filePermissions($item->id, auth('api')->user()->id) ? 1 : 0;
            return $file;
        });

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
            'file' => 'required'
        ]);

        if ($data->fails()) {
            return response()->json(['error' => __('admin.validation_error'), 'data' => $data->messages()], 400);
        }

        $data = $request->all();

        $data['file'] = Upload::upload([
            'file'        => 'file',
            'path'        => 'DataFiles',
            'upload_type' => 'single',
            'delete_file' => '',
        ]);

        $add_op_faild     = trans('admin.add_op_faild');
        $add_op_succ      = trans('admin.add_op_succ');
        $added = dataFiles::create($data);

        if ($added) {
            # Log to database
            $userType = 1;
            $log = logCreated($userType, auth('api')->user()->id, 'Data/Files', 'New File Added', json_encode($data));

            return response()->json(['message' => $add_op_succ,], 200);
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $delete_file = Upload::delete(dataFiles::find($id)->file);
        $data = dataFiles::find($id);
        $delete = dataFiles::where('id', $id)->delete();
        $succ_op   = trans('admin.del.op_succ');
        $failed_op = trans('admin.del.op_faild');

        if ($delete) {
            # Log to database
            $userType = 1;
            $log = logDeleted($userType, auth('api')->user()->id, 'Data/Files', 'File has been deleted', json_encode($data));

            return response()->json(['message' => $succ_op], 200);
        } else {
            return response()->json(['error_message' => $failed_op], 400);
        }
    }
}
