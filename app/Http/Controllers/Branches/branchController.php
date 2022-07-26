<?php

namespace App\Http\Controllers\Branches;

use App\Http\Controllers\Controller;
use App\Models\dashboard\location\countries;
use Illuminate\Http\Request;
use App\Http\Requests\BranchRequest;
use App\Models\dashboard\Branches\branch;
use App\Models\dashboard\location\cities;
use App\Models\dashboard\location\states;

class branchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data =  branch::with(['GetCountry', 'Getstate', 'GetCity'])->where('company_id', auth('admin')->user()->id)->simplepaginate(10);
        return view('dashboard.Branches.index', ['data' => $data, 'title' => __('list Branches')]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        # Fetch Countries . . .
        $countries = countries::get(['id', 'name', 'name_ar']);
        return view('dashboard.Branches.add', ['countries' => $countries, 'title' => __('Add Branche')]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BranchRequest $request)
    {
        # Fetch Data . . .
        $data = $request->except(['_token']);

        # Append Company Id . . .
        $data['company_id'] = auth('admin')->user()->id;

        $op = branch::create($data);

        $add_op_faild     = trans('admin.add_op_faild');
        $add_op_succ      = trans('admin.add_op_succ');

        if ($op) {
            session()->flash('message', $add_op_succ);
        } else {
            session()->flash('error_message', $add_op_faild);
        }

        return redirect(aurl('Branches'));
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

        $data = branch::find($id);

        # Get Countries . . .
        $countries = countries::get(['id', 'name', 'name_ar']);

        # Get States
        $states = states::where('country_id', $data->country_id)->get(['id', 'name', 'name_ar']);

        # Get Cities . . .
        $cities = cities::where('state_id', $data->state_id)->get(['id', 'name', 'name_ar']);

        return view('dashboard.Branches.edit', ['data' => $data, 'countries' => $countries, 'states' => $states, 'cities' => $cities]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BranchRequest $request, $id)
    {
        //
        $data =  $request->except(['_token', '_method']);

        $op = branch::find($id)->update($data);

        if ($op) {
            session()->flash('message', trans('admin.updated_record'));
        } else {
            session()->flash('error_message', trans('admin.updated_record_error'));
        }
        return redirect(aurl('Branches'));
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

        $op  = branch::find($id)->delete();

        $succ_op   = trans('admin.del.op_succ');
        $failed_op = trans('admin.del.op_faild');

        if ($op) {

            session()->flash('message', $succ_op);
        } else {
            session()->flash('error_message', $failed_op);
        }
        return redirect(aurl('Branches'));
    }
}
