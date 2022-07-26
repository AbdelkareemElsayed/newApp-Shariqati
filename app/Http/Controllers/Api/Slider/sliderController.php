<?php

namespace App\Http\Controllers\Api\Slider;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Upload;
use App\Models\dashboard\slider\slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
        return response()->json(['success' => __('admin.data_fetched'), 'data' => $slides]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = Validator::make($request->all(), [
            'title'    => 'nullable',
            'image'    => 'required|mimes:png,jpg,jpeg',
            'alt_text' => 'nullable'
        ]);

        if ($data->fails()) {
            return response()->json(['fail' => __('admin.validation_error'), 'data' => $data->messages()]);
        }

        $data = $request->all();

        $data['image'] = Upload::upload([
            'file'        => 'image',
            'path'        => 'Slider',
            'upload_type' => 'single',
            'delete_file' => '',
        ]);

        $slide = slider::create($data);

        # Log to database
        $userType = 1;
        $log = logCreated($userType, auth('api')->user()->id, 'Slides', 'New Slide Added', json_encode($data));

        return response()->json(['success' => __('admin.data_saved_successfully')]);;
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = Validator::make($request->all(),  [
            'title'    => 'nullable',
            'image'    => 'nullable|mimes:png,jpg,jpeg',
            'alt_text' => 'nullable',
        ]);

        if ($data->fails()) {
            return response()->json(['fail' => __('admin.validation_error'), 'data' => $data->messages()]);
        }

        $data = $request->all();

        if ($request->filled('image')) {
            $data['image'] = Upload::upload([
                'file'        => 'image',
                'path'        => 'Slider',
                'upload_type' => 'single',
                'delete_file' => slider::find($id)->image,
            ]);
        } else {
            $data['image'] = slider::where('id', $id)->get()[0]->image;
        }
        $oldData = slider::find($id);
        $slide = slider::where('id', $id)->update($data);

        # Log to database
        $userType = 1;
        $log = logUpdated($userType, auth('api')->user()->id, 'Slider', 'Slide has been updated', json_encode($data), json_encode($oldData));

        return response()->json(['success' => __('admin.data_updated_successfully')]);
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
        $deleted = slider::where('id', $id)->delete();

        # Log to database
        $userType = 1;
        $log = logDeleted($userType, auth('api')->user()->id, 'Slides', 'Slide has been deleted', json_encode($data));

        return response()->json(['success' => __('admin.delete_successfully')]);
    }
}
