<?php

namespace App\Http\Controllers\Location;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Notifications\firebaseController;
use App\Models\dashboard\location\cities;
use Illuminate\Http\Request;
use App\Http\Requests\cityRequest;
use App\Models\dashboard\admins\admin;

class citiesController extends Controller
{

    ###########################################################################################################
    public function LoadCities($sateId)
    {
        $data = cities::where('state_id', $sateId)->simplePaginate(10);

        # SET COUNTRY SESSION . . .
        session()->put('state_id', $sateId);

        return view('dashboard.Location.cities.index', ['data' => $data, 'title' => trans('admin.listCities')]);
    }
    ###########################################################################################################

    ###########################################################################################################
    public function LoadCitiesJSON(Request $request)
    {
        $data = cities::where('state_id', $request->state_id)->get();

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
        return view('dashboard.Location.cities.add', ['title' => trans('admin.addCountry')]);
    }

    #############################################################################################################
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(cityRequest $request)
    {
        //

        $data = $request->except('_token');

        # Set Country Id . . . 
        $data['country_id'] = session()->get('country_id');

        # Set State Id . . . 
        $data['state_id'] = session()->get('state_id');


        $op = cities::create($data);

        $add_op_faild     = trans('admin.add_op_faild');
        $add_op_succ      = trans('admin.add_op_succ');
        if ($op) {
            # Log to database
            $userType = auth('admin')->check() ? 1 : 2;
            $log = logCreated($userType, auth('admin')->user()->id, 'Cities', 'New City Added', json_encode($data));

            $tokens = admin::pluck('fcm_token')->toArray();
            $data = ['title' => 'Citites', 'content' => 'City added', 'title_ar' => 'المدن', 'content_ar' => 'تم اضافة مدينة'];
            firebaseController::notifyUsers($tokens, $data);


            session()->flash('message', $add_op_succ);
        } else {
            session()->flash('error_message', $add_op_faild);
        }

        return redirect(aurl('Location/Countries/States/Cities/' . session()->get('state_id')));
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
        $data = cities::find($id);
        $title = trans('admin.editState');

        return view('dashboard.Location.cities.edit', ['title' => $title, 'data' => $data]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(cityRequest $request, $id)
    {
        //
        $data = $request->except(['_token', '_method']);

        $oldData = cities::find($id);
        $op = cities::where('id', $id)->update($data);

        if ($op) {
            # Log to database
            $userType = auth('admin')->check() ? 1 : 2;
            $log = logUpdated($userType, auth('admin')->user()->id, 'Cities', 'City has been updated', json_encode($data), json_encode($oldData));

            $tokens = admin::pluck('fcm_token')->toArray();
            $data = ['title' => 'Citites', 'content' => 'City updated', 'title_ar' => 'المدن', 'content_ar' => 'تم تحديث مدينة'];
            firebaseController::notifyUsers($tokens, $data);

            session()->flash('message', trans('admin.updated_record'));
        } else {
            session()->flash('error_message', trans('admin.updated_record_error'));
        }
        return redirect(aurl('Location/Countries/States/Cities/' . session()->get('state_id')));
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
        $data = cities::find($id);
        $op = $data->delete();

        $succ_op   = trans('admin.del.op_succ');
        $failed_op = trans('admin.del.op_faild');

        if ($op) {
            # Log to database
            $userType = auth('admin')->check() ? 1 : 2;
            $log = logDeleted($userType, auth('admin')->user()->id, 'Cities', 'City has been deleted', json_encode($data));

            $tokens = admin::pluck('fcm_token')->toArray();
            $data = ['title' => 'Citites', 'content' => 'City deleted', 'title_ar' => 'المدن', 'content_ar' => 'تم حذف مدينة'];
            firebaseController::notifyUsers($tokens, $data);

            session()->flash('message', $succ_op);
        } else {
            session()->flash('error_message', $failed_op);
        }

        return redirect(aurl('Location/Countries/States/Cities/' . session()->get('state_id')));
    }
}
