<?php

namespace App\Http\Controllers\Slider;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Notifications\firebaseController;
use App\Http\Controllers\Upload;
use App\Http\Requests\sliderRequest;
use App\Models\dashboard\admins\admin;
use App\Models\dashboard\slider\slider;
use Illuminate\Http\Request;

class sliderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $slides = slider::orderBy('id', 'desc')->get();
        return view('dashboard.Slider.index', ['data' => $slides, 'title' => trans('admin.addSlide')]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.Slider.add', ['title' => trans('admin.addSlide')]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(sliderRequest $request)
    {
        $data = $request->except(['_token']);
        $data['image'] = Upload::upload([
            'file'        => 'image',
            'path'        => 'Slider',
            'upload_type' => 'single',
            'delete_file' => '',
        ]);

        $slide = slider::create($data);

        $add_op_faild     = trans('admin.add_op_faild');
        $add_op_succ      = trans('admin.add_op_succ');
        if ($slide) {
            # Log to database
            $userType = auth('admin')->check() ? 1 : 2;
            $log = logCreated($userType, auth('admin')->user()->id, 'Slides', 'New Slide Added', json_encode($data));

            $tokens = admin::pluck('fcm_token')->toArray();
            $data = ['title' => 'Slider', 'content' => 'Slider added', 'title_ar' => 'السلايدر', 'content_ar' => 'تم اضافة شريحة'];
            firebaseController::notifyUsers($tokens, $data);

            session()->flash('message', $add_op_succ);
        } else {
            session()->flash('error_message', $add_op_faild);
        }

        return redirect(aurl('Slider'));
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
        $slide = slider::find($id);
        return view('dashboard.Slider.edit', ['slide' => $slide, 'title' => trans('admin.editSlide')]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(sliderRequest $request, $id)
    {
        $data = $request->except(['_token', '_method']);
        if ($request->has('image')) {
            $data['image'] = Upload::upload([
                'file'        => 'image',
                'path'        => 'Slider',
                'upload_type' => 'single',
                'delete_file' => slider::find($id)->image,
            ]);
        } else {
            $data['image'] = slider::find($id)->image;
        }

        $oldData = slider::find($id);
        $slide = slider::where('id', $id)->update($data);
        if ($slide) {
            # Log to database
            $userType = auth('admin')->check() ? 1 : 2;
            $log = logUpdated($userType, auth('admin')->user()->id, 'Slider', 'Slide has been updated', json_encode($data), json_encode($oldData));

            $tokens = admin::pluck('fcm_token')->toArray();
            $data = ['title' => 'Slider', 'content' => 'Slider updated', 'title_ar' => 'السلايدر', 'content_ar' => 'تم تحديث شريحة'];
            firebaseController::notifyUsers($tokens, $data);


            session()->flash('message', trans('admin.updated_record'));
        } else {
            session()->flash('error_message', trans('admin.updated_record_error'));
        }

        return redirect(aurl('Slider'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $delete_image = Upload::delete(slider::find($id)->image);
        $data = slider::find($id);
        $deleted = $data->delete();

        $succ_op   = trans('admin.del.op_succ');
        $failed_op = trans('admin.del.op_faild');
        if ($deleted) {
            # Log to database
            $userType = auth('admin')->check() ? 1 : 2;
            $log = logDeleted($userType, auth('admin')->user()->id, 'Slides', 'Slide has been deleted', json_encode($data));

            $tokens = admin::pluck('fcm_token')->toArray();
            $data = ['title' => 'Slider', 'content' => 'Slider deleted', 'title_ar' => 'السلايدر', 'content_ar' => 'تم حذف شريحة'];
            firebaseController::notifyUsers($tokens, $data);

            session()->flash('message', $succ_op);
        } else {
            session()->flash('error_message', $failed_op);
        }
        return redirect()->back();
    }
}
