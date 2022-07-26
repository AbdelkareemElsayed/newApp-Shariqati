<?php

namespace App\Http\Controllers\Customers;

use App\Http\Controllers\Controller;
use App\Models\address;
use App\Models\dashboard\location\countries;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\AddressRequest;
use App\Models\dashboard\location\cities;
use App\Models\dashboard\location\states;

class addressController extends Controller
{


    public function customersAddress($id)
    {

        # Set User Session . . . 
        session()->put('customer_id', $id);

        $data = address::with('GetCustomerCountry')->with('GetCustomerStates')->with('GetCustomerCity')->where('user_id', $id)->get();

        return view('dashboard.Customers.Address.index', ['title' => trans('admin.addTitle'), 'data' => $data]);
    }



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }


    ###############################################################################################################
    /*
     * Show the form for creating a new resource.
     * @return \Illuminate\Http\Response. 
     *
     */

    public function create()
    {

        # Fetch Current Customer Address Details . . .     
        $data =   User::with('GetCustomerCountry.States')->find(session()->get('customer_id'));

        return view('dashboard.Customers.Address.add', ['title' => trans('admin.addAddress'), 'data' => $data]);
    }
    ###############################################################################################################

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AddressRequest $request)
    {
        //
        $data  = $request->except('_token');

        # Append Customer id
        $data['user_id'] =  session()->get('customer_id');

        if ($request->has('is_default')) {
            $data['is_default'] =  1;
        }

        $op = address::create($data);

        $add_op_faild     = trans('admin.add_op_faild');
        $add_op_succ      = trans('admin.add_op_succ');

        if ($op) {
            # Log to database
            $userType = auth('admin')->check() ? 1 : 2;
            $log = logCreated($userType, auth('admin')->user()->id, 'customerAddress', 'New Address Added', json_encode($data));

            session()->flash('message', $add_op_succ);
        } else {
            session()->flash('error_message', $add_op_faild);
        }

        return redirect(aurl('Customers/Address/' . session()->get('customer_id')));
    }
    #############################################################################################################

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
        # Fetch Raw Data . . . 
        $data = address::with('GetCustomerCountry')->with('GetCustomerStates')->with('GetCustomerCity')->where('user_id', $id)->findOrFail($id);

        # Fetch State Data . . . 
        $states = states::where('country_id', $data->country_id)->get();

        # Fetch Cities . . . 
        $cities = cities::where('state_id', $data->state_id)->get();

        return view('dashboard.Customers.Address.edit', ['title' => trans('admin.editAddress'), 'data' => $data, 'states' => $states, 'cities' => $cities]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AddressRequest $request, $id)
    {
        //

        $data  = $request->except('_token', '_method');
        $oldData = address::find($id);

        # Append Customer id
        $data['user_id'] =  session()->get('customer_id');

        if ($request->has('is_default')) {
            $data['is_default'] =  1;
        } else {
            $data['is_default'] =  0;
        }

        $op = address::find($id)->update($data);

        $add_op_faild     = trans('admin.add_op_faild');
        $add_op_succ      = trans('admin.add_op_succ');

        if ($op) {
            # Log to database
            $userType = auth('admin')->check() ? 1 : 2;
            $log = logUpdated($userType, auth('admin')->user()->id, 'customerAddress', 'Address has been updated', json_encode($data), json_encode($oldData));

            session()->flash('message', trans('admin.updated_record'));
        } else {
            session()->flash('error_message', trans('admin.updated_record_error'));
        }

        return redirect(aurl('Customers/Address/' . session()->get('customer_id')));
    }

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
        $data = address::find($id);
        $op = $data->delete();

        $succ_op   = trans('admin.del.op_succ');
        $failed_op = trans('admin.del.op_faild');

        if ($op) {
            # Log to database
            $userType = auth('admin')->check() ? 1 : 2;
            $log = logDeleted($userType, auth('admin')->user()->id, 'customerAdress', 'Address has been deleted', json_encode($data));


            session()->flash('message', $succ_op);
        } else {
            session()->flash('error_message', $failed_op);
        }

        return redirect(aurl('Customers/Address/' . session()->get('customer_id')));
    }
}
