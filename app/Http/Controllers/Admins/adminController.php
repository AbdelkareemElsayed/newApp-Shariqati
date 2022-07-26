<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Notifications\firebaseController;
use Illuminate\Http\Request;
use App\Models\dashboard\admins\admin;
use App\Models\dashboard\roles\adminRoles;
use App\Http\Requests\adminRequest;
use App\Http\Controllers\Upload;

class adminController extends Controller
{

    ####################################################################################################################
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        # Get Admins Data  . . .
        $data = admin::with('role.roleData')->orderBy('id', 'desc')->get();

        return view('dashboard.admins.index', ['title' => trans('admin.admincontrol'), 'data' => $data]);
    }

    ####################################################################################################################
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles =  adminRoles::with('roleData')->get();
        return view('dashboard.admins.add', ['roles' => $roles, 'title' => trans('admin.addadmin')]);
    }
    ####################################################################################################################


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(adminRequest $request)
    {
        # Fetch Request Data . . .
        $data = $request->except('_token');

        # Hash Password . . .
        $data['password'] = bcrypt(request('password'));

        # Upload Image . . . .
        $data['image'] = Upload::upload([
            'file'        => 'image',
            'path'        => 'AdminsAccount',
            'upload_type' => 'single',
            'delete_file' => '',
        ]);

        # Insert data . . .   
        $op               =  admin::create($data);

        $add_op_faild     = trans('admin.add_op_faild');
        $add_op_succ      = trans('admin.add_op_succ');

        if ($op) {
            # Log to database
            $userType = auth('admin')->check() ? 1 : 2;
            $log = logCreated($userType, auth('admin')->user()->id, 'Admins', 'New Admin Added', json_encode($data));

            $tokens = admin::pluck('fcm_token')->toArray();
            $data = ['title' => 'Admins', 'content' => 'Admin added', 'title_ar' => 'المشرفين', 'content_ar' => 'تم اضافة مشرف'];
            firebaseController::notifyUsers($tokens, $data);

            session()->flash('message', $add_op_succ);
        } else {
            session()->flash('error_message', $add_op_faild);
        }

        return redirect(aurl('Admins'));
    }

    ####################################################################################################################

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

    ####################################################################################################################

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        # Get Raw . . .
        $data = admin::find($id);

        # Get Admins Data  . . .
        $roles = adminRoles::with('roleData')->get();

        $title = trans('admin.edit');

        return view('dashboard.admins.edit', ['title' => $title, 'data' => $data, 'roles' => $roles]);
    }

    ####################################################################################################################

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(adminRequest $request, $id)
    {
        //

        $data = $request->except(['_token', 'changePassword', '_method', 'password']);
        $old_data = Admin::find($id);

        # Check If A new Request Sended || NOT  . . .
        if ($request->changePassword == true) {
            $data['password'] = bcrypt(request('password'));
        }

        # Check If Request Has New Image || Not . . .
        if (request()->hasFile('image')) {
            $data['image'] = Upload::upload([
                'file'        => 'image',
                'path'        => 'AdminsAccount',
                'upload_type' => 'single',
                'delete_file' => admin::find($id)->image,
            ]);
        }


        $op = Admin::where('id', $id)->update($data);

        if ($op) {
            # Log to database
            $userType = auth('admin')->check() ? 1 : 2;
            $log = logUpdated($userType, auth('admin')->user()->id, 'Admins', 'Admin has been updated', json_encode($op), json_encode($old_data));

            $tokens = admin::pluck('fcm_token')->toArray();
            $data = ['title' => 'Admins', 'content' => 'Admin updated', 'title_ar' => 'المشرفين', 'content_ar' => 'تم تحديث مشرف'];
            firebaseController::notifyUsers($tokens, $data);

            session()->flash('message', trans('admin.updated_record'));
        } else {
            session()->flash('error_message', trans('admin.updated_record_error'));
        }
        return redirect(aurl('Admins'));
    }

    ####################################################################################################################

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        # Check If The Deleted Raw == Current Account 
        if ($id == auth('admin')->user()->id) {
            session()->flash('error_message', trans("Can't Delete Your Account"));
        } else {

            # Get Admin Image . . . 
            $image  = admin::find($id)->image;

            # Delete Raw . . .
            $data = admin::find($id);
            $op = $data->delete();

            $succ_op   = trans('admin.del.op_succ');
            $failed_op = trans('admin.del.op_faild');

            if ($op) {

                # Delete Image . . .
                Upload::delete($image);

                # Log to database
                $userType = auth('admin')->check() ? 1 : 2;
                $log = logDeleted($userType, auth('admin')->user()->id, 'Admins', 'Admin has been deleted', json_encode($data));

                $tokens = admin::pluck('fcm_token')->toArray();
                $data = ['title' => 'Admins', 'content' => 'Admin deleted', 'title_ar' => 'المشرفين', 'content_ar' => 'تم حذف مشرف'];
                firebaseController::notifyUsers($tokens, $data);

                session()->flash('message', $succ_op);
            } else {
                session()->flash('error_message', $failed_op);
            }
        }

        return redirect(aurl('Admins'));
    }
    ####################################################################################################################
    # GET PROFILE DATA . . . 
    public function showProfile()
    {
        # Get Raw . . .
        $data = admin::find(auth('admin')->user()->id);

        $title = trans('admin.updateProfile');

        return view('dashboard.profile.edit', ['title' => $title, 'data' => $data]);
    }


    ####################################################################################################################
    # Update Profile . . .
    public function UpdateProfile(adminRequest $request, $id)
    {
        //

        $data = $request->except(['_token', 'changePassword', '_method', 'password']);

        # Check If A new Request Sended || NOT  . . .
        if ($request->changePassword == true) {
            $data['password'] = bcrypt(request('password'));
        }

        # Check If Request Has New Image || Not . . .
        if (request()->hasFile('image')) {
            $data['image'] = Upload::upload([
                'file'        => 'image',
                'path'        => 'AdminsAccount',
                'upload_type' => 'single',
                'delete_file' => admin::find($id)->image,
            ]);
        }


        $op = Admin::where('id', $id)->update($data);

        if ($op) {
            session()->flash('message', trans('admin.updated_profile'));
        } else {
            session()->flash('error_message', trans('admin.updated_record_error'));
        }
        return redirect()->back();
    }

    ####################################################################################################################







}
