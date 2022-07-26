<?php

namespace App\Http\Controllers\Customers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Notifications\firebaseController;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\CustomerRequest;
use App\Http\Controllers\Upload;
use App\Models\dashboard\admins\admin;
use App\Models\dashboard\location\countries;

class CustomerController extends Controller
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
        $data = User::orderBy('id', 'desc')->get();
        return view('dashboard.Customers.index', ['title' => trans('admin.customerscontrol'), 'data' => $data]);
    }

    ####################################################################################################################
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        # Fetch Countries . . .
        $countries = countries::get();

        return view('dashboard.Customers.add', ['countries' => $countries, 'title' => trans('admin.addCustomer')]);
    }
    ####################################################################################################################


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CustomerRequest $request)
    {

        # Fetch Request Data . . .
        $data = $request->except('_token');

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

        $add_op_faild     = trans('admin.add_op_faild');
        $add_op_succ      = trans('admin.add_op_succ');

        if ($op) {
            loggers(2, $op->id, Request()->ip(), 3);

            # Log to database
            $userType = auth('admin')->check() ? 1 : 2;
            $log = logCreated($userType, auth('admin')->user()->id, 'Customers', 'New Customer Added', json_encode($data));

            $tokens = admin::pluck('fcm_token')->toArray();
            $data = ['title' => 'Customers', 'content' => 'Customer added', 'title_ar' => 'العملاء', 'content_ar' => 'تم اضافة عميل'];
            firebaseController::notifyUsers($tokens, $data);

            session()->flash('message', $add_op_succ);
        } else {
            session()->flash('error_message', $add_op_faild);
        }

        return redirect(aurl('Customers'));
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

        # Fetch Raw Data . . .
        $data = User::find($id);

        # Fetch Countries . . .
        $countries = countries::get();

        $title = trans('admin.edit');

        return view('dashboard.Customers.edit', ['countries' => $countries, 'title' => $title, 'data' => $data]);
    }
    ####################################################################################################################
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CustomerRequest $request, $id)
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
                'path'        => 'CustomersAccount',
                'upload_type' => 'single',
                'delete_file' => User::find($id)->image,
            ]);
        }

        $oldData = User::find($id);
        $op = User::where('id', $id)->update($data);

        if ($op) {
            # Log to database
            $userType = auth('admin')->check() ? 1 : 2;
            $log = logUpdated($userType, auth('admin')->user()->id, 'Customers', 'Customer has been updated', json_encode($data), json_encode($oldData));

            $tokens = admin::pluck('fcm_token')->toArray();
            $data = ['title' => 'Customers', 'content' => 'Customer updated', 'title_ar' => 'العملاء', 'content_ar' => 'تم تحديث عميل'];
            firebaseController::notifyUsers($tokens, $data);

            session()->flash('message', trans('admin.updated_record'));
        } else {
            session()->flash('error_message', trans('admin.updated_record_error'));
        }
        return redirect(aurl('Customers'));
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

        # Get Admin Image . . .
        $image  = User::find($id)->image;

        # Delete Raw . . .
        $data = User::find($id);
        $op = $data->delete();

        $succ_op   = trans('admin.del.op_succ');
        $failed_op = trans('admin.del.op_faild');

        if ($op) {

            # Delete Image . . .
            Upload::delete($image);

            # Log to database
            $userType = auth('admin')->check() ? 1 : 2;
            $log = logDeleted($userType, auth('admin')->user()->id, 'Customers', 'Customer has been deleted', json_encode($data));

            $tokens = admin::pluck('fcm_token')->toArray();
            $data = ['title' => 'Customers', 'content' => 'Customer deleted', 'title_ar' => 'العملاء', 'content_ar' => 'تم حذف عميل'];
            firebaseController::notifyUsers($tokens, $data);

            session()->flash('message', $succ_op);
        } else {
            session()->flash('error_message', $failed_op);
        }

        return redirect(aurl('Customers'));
    }
    ####################################################################################################################
}
