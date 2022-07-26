<?php

namespace App\Http\Controllers\Data;

use App\Http\Controllers\Controller;
use App\Models\dashboard\Data\accessRequests;
use App\Models\dashboard\Data\userFilePermissions;
use Illuminate\Http\Request;

class accessRequestsController extends Controller
{
    public function index()
    {
        $requests = accessRequests::with('requestFile')->with('requestUser')->orderBy('id', 'desc')->get();
        return view('dashboard.Data.Files.AccessRequests.index', ['data' => $requests, 'title' => trans('admin.accessRequests')]);
    }

    public function grantAccess($id)
    {
        $request = accessRequests::find($id);

        $delete = userFilePermissions::where(['user_id' => $request->user_id, 'file_id' => $request->file_id])->delete();

        $addPermission = userFilePermissions::create(['user_id' => $request->user_id, 'file_id' => $request->file_id]);

        if ($addPermission) {
            $added = accessRequests::where('id', $id)->update(['status' => 1]);

            $add_op_faild     = trans('admin.add_op_faild');
            $add_op_succ      = trans('admin.add_op_succ');
            if ($added) {
                session()->flash('message', $add_op_succ);
            } else {
                session()->flash('error_message', $add_op_faild);
            }
            return redirect()->back();
        }
    }

    public function rejectAccess($id)
    {
        $request = accessRequests::find($id);
        $delete = userFilePermissions::where(['user_id' => $request->user_id, 'file_id' => $request->file_id])->delete();
        $added = accessRequests::where('id', $id)->update(['status' => 2]);
        $add_op_faild     = trans('admin.add_op_faild');
        $add_op_succ      = trans('admin.add_op_succ');
        if ($added) {
            session()->flash('message', $add_op_succ);
        } else {
            session()->flash('error_message', $add_op_faild);
        }
        return redirect()->back();
    }
}
