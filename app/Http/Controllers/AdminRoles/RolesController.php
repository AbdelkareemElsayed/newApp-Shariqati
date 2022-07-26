<?php

namespace App\Http\Controllers\AdminRoles;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Notifications\firebaseController;
use App\Http\Middleware\lang;
use Illuminate\Http\Request;
use App\Http\Requests\rolesRequest;
use App\Models\dashboard\admins\admin;
use App\Models\dashboard\roles\adminRoles;
use App\Models\dashboard\roles\adminrolesTitles;
use App\Models\dashboard\Modules\modules;
use App\Models\dashboard\Modules\modulesPermissions;

class RolesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data = adminRoles::with('roleData')->with('permissions.module')->get();

        return view('dashboard.AdminRoles.index', ['data' => $data, 'title' => trans('admin.listRoles')]);
    }

    #######################################################################################################################    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Get Modules . . .
        $modules =  modules::get();

        return view('dashboard.AdminRoles.add', ['modules' => $modules, 'title' => trans('admin.addRole')]);
    }

    #######################################################################################################################
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(rolesRequest $request)
    {
        # Fetch Data . . .
        $data = $request->only('title_ar', 'title_en');
        // dd($request->all());  
        $Raw =  adminRoles::create();

        foreach ($data as $key => $value) {
            # Get Lang . . .
            $split = explode('_', $key);
            $lang = end($split);

            # Store Titles Of Roles . . .
            $op =  adminrolesTitles::create(['title' => $value, "lang" => $lang, "role_id" => $Raw->id]);
        }

        # Store Permissions . . . 
        foreach ($request->module_id as $key => $value) {

            $show   = 'show' . $value;
            $create = 'create' . $value;
            $update = 'update' . $value;
            $delete = 'delete' . $value;

            modulesPermissions::create(["role_id" => $Raw->id, 'module_id' => $value,  'is_show' => $request->$show, 'is_create' => $request->$create, 'is_update' => $request->$update, 'is_delete' => $request->$delete]);
        }


        $add_op_faild     = trans('admin.add_op_faild');
        $add_op_succ      = trans('admin.add_op_succ');

        if ($op) {
            # Log to database
            $userType = auth('admin')->check() ? 1 : 2;
            $log = logCreated($userType, auth('admin')->user()->id, 'Roles', 'New Role Added', json_encode($data));

            $tokens = admin::pluck('fcm_token')->toArray();
            $data = ['title' => 'Roles', 'content' => 'New role added', 'title_ar' => 'الصلاحيات', 'content_ar' => 'تم اضافة صلاحية'];
            firebaseController::notifyUsers($tokens, $data);

            session()->flash('message', $add_op_succ);
        } else {
            session()->flash('error_message', $add_op_faild);
        }

        return redirect(aurl('Roles'));
    }

    #######################################################################################################################
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

    #######################################################################################################################
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        # Get Raw Data . . . 
        $data = adminRoles::with('roleDataGenralLang')->with('permissions')->find($id);

        # Get Modules . . . 
        $modules =  modules::get();

        return view('dashboard.AdminRoles.edit', ['title' => trans('admin.editRole'), 'data' => $data, 'modules' => $modules]);
    }

    #######################################################################################################################
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(rolesRequest $request, $id)
    {
        //

        # Fetch Data . . .
        $data = $request->only('title_en', 'title_ar');

        # Remove Old Values .... 
        $old_data = adminrolesTitles::where('role_id', $id)->get()[0];
        adminrolesTitles::where('role_id', $id)->delete();

        foreach ($data as $key => $value) {
            # Get Lang . . .
            $split = explode('_', $key);
            $lang  = end($split);

            $op =  adminrolesTitles::create(['title' => $value, "lang" => $lang, "role_id" => $id]);
        }

        # Remove permission . . . 
        modulesPermissions::where("role_id", $id)->delete();

        # Store Permissions . . . 
        foreach ($request->module_id as $key => $value) {

            $show   = 'show' . $value;
            $create = 'create' . $value;
            $update = 'update' . $value;
            $delete = 'delete' . $value;

            modulesPermissions::create(["role_id" => $id, 'module_id' => $value,  'is_show' => $request->$show, 'is_create' => $request->$create, 'is_update' => $request->$update, 'is_delete' => $request->$delete]);
        }


        if ($op) {
            # Log to database
            $userType = auth('admin')->check() ? 1 : 2;
            $log = logUpdated($userType, auth('admin')->user()->id, 'Roles', 'Role has been updated', json_encode($op), json_encode($old_data));

            $tokens = admin::pluck('fcm_token')->toArray();
            $data = ['title' => 'Roles', 'content' => 'Role updated', 'title_ar' => 'الصلاحيات', 'content_ar' => 'تم تحديث صلاحية'];
            firebaseController::notifyUsers($tokens, $data);

            session()->flash('message', trans('admin.updated_record'));
        } else {
            session()->flash('error_message', trans('admin.updated_record_error'));
        }
        return redirect(aurl('Roles'));
    }

    #######################################################################################################################
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //

        # Delete Raw . . .
        $data = adminRoles::find($id);
        $op = $data->delete();

        $succ_op   = trans('admin.del.op_succ');
        $failed_op = trans('admin.del.op_faild');

        if ($op) {
            # Log to database
            $userType = auth('admin')->check() ? 1 : 2;
            $log = logDeleted($userType, auth('admin')->user()->id, 'Roles', 'Role has been deleted', json_encode($data));

            $tokens = admin::pluck('fcm_token')->toArray();
            $data = ['title' => 'Roles', 'content' => 'Role deleted', 'title_ar' => 'الصلاحيات', 'content_ar' => 'تم حذف صلاحية'];
            firebaseController::notifyUsers($tokens, $data);

            session()->flash('message', $succ_op);
        } else {
            session()->flash('error_message', $failed_op);
        }

        return redirect(aurl('Roles'));
    }

    #######################################################################################################################
}
