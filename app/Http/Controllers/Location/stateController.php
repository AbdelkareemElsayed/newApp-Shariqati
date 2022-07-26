<?php

namespace App\Http\Controllers\Location;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Notifications\firebaseController;
use Illuminate\Http\Request;
use App\Models\dashboard\location\states;
use App\Http\Requests\stateRequest;
use App\Models\dashboard\admins\admin;

class stateController extends Controller
{


    ###########################################################################################################
    public function LoadState($countryId)
    {
        $data = states::where('country_id', $countryId)->simplePaginate(10);

        # SET COUNTRY SESSION . . .
        session()->put('country_id', $countryId);

        return view('dashboard.Location.states.index', ['data' => $data, 'title' => trans('admin.listState')]);
    }

    ###########################################################################################################
    public function LoadStateJSON(Request $request)
    {
        $data = states::where('country_id', $request->countryId)->get();

        return response()->json(['data' => $data]);
    }
    ###########################################################################################################


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }


    #############################################################################################################
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('dashboard.Location.states.add', ['title' => trans('admin.addCountry')]);
    }

    #############################################################################################################
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(stateRequest $request)
    {
        //

        $data = $request->except('_token');

        # Set Country Id . . .
        $data['country_id'] = session()->get('country_id');

        $op = states::create($data);

        $add_op_faild     = trans('admin.add_op_faild');
        $add_op_succ      = trans('admin.add_op_succ');
        if ($op) {
            # Log to database
            $userType = auth('admin')->check() ? 1 : 2;
            $log = logCreated($userType, auth('admin')->user()->id, 'States', 'New State Added', json_encode($data));

            $tokens = admin::pluck('fcm_token')->toArray();
            $data = ['title' => 'States', 'content' => 'State added', 'title_ar' => 'المحافظات', 'content_ar' => 'تم اضافة المحافظة'];
            firebaseController::notifyUsers($tokens, $data);

            session()->flash('message', $add_op_succ);
        } else {
            session()->flash('error_message', $add_op_faild);
        }

        return redirect(aurl('Location/Countries/State/' . session()->get('country_id')));
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
        //
        $data = states::find($id);
        $title = trans('admin.editState');

        return view('dashboard.Location.states.edit', ['title' => $title, 'data' => $data]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(stateRequest $request, $id)
    {
        //
        $data = $request->except(['_token', '_method']);

        $oldData = states::find($id);
        $op = states::where('id', $id)->update($data);

        if ($op) {
            # Log to database
            $userType = auth('admin')->check() ? 1 : 2;
            $log = logUpdated($userType, auth('admin')->user()->id, 'States', 'State has been updated', json_encode($data), json_encode($oldData));

            $tokens = admin::pluck('fcm_token')->toArray();
            $data = ['title' => 'States', 'content' => 'State updated', 'title_ar' => 'المحافظات', 'content_ar' => 'تم تحديث المحافظة'];
            firebaseController::notifyUsers($tokens, $data);

            session()->flash('message', trans('admin.updated_record'));
        } else {
            session()->flash('error_message', trans('admin.updated_record_error'));
        }
        return redirect(aurl('Location/Countries/State/' . session()->get('country_id')));
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

        $data = states::find($id);
        $op = $data->delete();

        $succ_op   = trans('admin.del.op_succ');
        $failed_op = trans('admin.del.op_faild');

        if ($op) {
            # Log to database
            $userType = auth('admin')->check() ? 1 : 2;
            $log = logDeleted($userType, auth('admin')->user()->id, 'States', 'State has been deleted', json_encode($data));

            $tokens = admin::pluck('fcm_token')->toArray();
            $data = ['title' => 'States', 'content' => 'State deleted', 'title_ar' => 'المحافظات', 'content_ar' => 'تم حذف المحافظة'];
            firebaseController::notifyUsers($tokens, $data);

            session()->flash('message', $succ_op);
        } else {
            session()->flash('error_message', $failed_op);
        }

        return redirect(aurl('Location/Countries/State/' . session()->get('country_id')));
    }
}
