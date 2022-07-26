<?php

namespace App\Http\Controllers\Location;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Notifications\firebaseController;
use App\Models\dashboard\location\countries;
use Illuminate\Http\Request;
use App\Http\Requests\countryRequest;
use App\Models\dashboard\admins\admin;

class countriesController extends Controller
{


    #############################################################################################################
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data = countries::orderbydesc('id')->simplePaginate(10);

        return view('dashboard.Location.countries.index', ['data' => $data, 'title' => trans('admin.listCountries')]);
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
        return view('dashboard.Location.countries.add', ['title' => trans('admin.addCountry')]);
    }

    #############################################################################################################
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(countryRequest $request)
    {
        //

        $data = $request->except('_token');

        $op = countries::create($data);

        $add_op_faild     = trans('admin.add_op_faild');
        $add_op_succ      = trans('admin.add_op_succ');
        if ($op) {
            # Log to database
            $userType = auth('admin')->check() ? 1 : 2;
            $log = logCreated($userType, auth('admin')->user()->id, 'Countries', 'New Country Added', json_encode($data));

            $tokens = admin::pluck('fcm_token')->toArray();
            $data = ['title' => 'Countries', 'content' => 'Country added', 'title_ar' => 'الدول', 'content_ar' => 'تم اضافة دولة'];
            firebaseController::notifyUsers($tokens, $data);

            session()->flash('message', $add_op_succ);
        } else {
            session()->flash('error_message', $add_op_faild);
        }

        return redirect(aurl('Location/Countries'));
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
    }
    #############################################################################################################

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $data = countries::find($id);
        $title = trans('admin.editContry');

        return view('dashboard.Location.countries.edit', ['title' => $title, 'data' => $data]);
    }


    #############################################################################################################

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(countryRequest $request, $id)
    {
        //
        $data = $request->except(['_token', '_method']);

        $oldData = countries::find($id);
        $op = countries::where('id', $id)->update($data);

        if ($op) {
            # Log to database
            $userType = auth('admin')->check() ? 1 : 2;
            $log = logUpdated($userType, auth('admin')->user()->id, 'Countries', 'Country has been updated', json_encode($data), json_encode($oldData));

            $tokens = admin::pluck('fcm_token')->toArray();
            $data = ['title' => 'Countries', 'content' => 'Country updated', 'title_ar' => 'الدول', 'content_ar' => 'تم تحديث الدولة'];
            firebaseController::notifyUsers($tokens, $data);

            session()->flash('message', trans('admin.updated_record'));
        } else {
            session()->flash('error_message', trans('admin.updated_record_error'));
        }
        return redirect(aurl('Location/Countries'));
    }

    #############################################################################################################
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //

        $data = countries::find($id);
        $op = $data->delete();

        $succ_op   = trans('admin.del.op_succ');
        $failed_op = trans('admin.del.op_faild');

        if ($op) {
            # Log to database
            $userType = auth('admin')->check() ? 1 : 2;
            $log = logDeleted($userType, auth('admin')->user()->id, 'Countries', 'Country has been deleted', json_encode($data));

            $tokens = admin::pluck('fcm_token')->toArray();
            $data = ['title' => 'Countries', 'content' => 'Country deleted', 'title_ar' => 'الدول', 'content_ar' => 'تم حذف الدولة'];
            firebaseController::notifyUsers($tokens, $data);

            session()->flash('message', $succ_op);
        } else {
            session()->flash('error_message', $failed_op);
        }

        return redirect(aurl('Location/Countries'));
    }

    #############################################################################################################
}
