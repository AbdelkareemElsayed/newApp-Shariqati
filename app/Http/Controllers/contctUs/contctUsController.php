<?php

namespace App\Http\Controllers\contctUs;

use App\Http\Controllers\Controller;
use App\Models\dashboard\contactUs\contactUs;
use Illuminate\Http\Request;

class contctUsController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data = contactUs::simplePaginate(15);

        return view('dashboard.contactUs.index', ['data' => $data, 'title' => __('admin.ConatctUsMessages')]);
    }

    #####################################################################################################################


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        # Remove Raw . . .
        $op = contactUs::find($id)->delete();

        if ($op) {
            session()->flash('message', trans('admin.updated_profile'));
        } else {
            session()->flash('error_message', trans('admin.updated_record_error'));
        }

        return  redirect(aurl('ContactUs'));
    }

    #####################################################################################################################

}
