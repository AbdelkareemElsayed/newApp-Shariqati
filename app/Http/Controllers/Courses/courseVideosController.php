<?php

namespace App\Http\Controllers\Courses;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Notifications\firebaseController;
use App\Http\Controllers\Upload;
use App\Http\Requests\courseVideosRequest;
use App\Models\dashboard\admins\admin;
use App\Models\dashboard\Courses\courseVideos;
use Illuminate\Http\Request;

class courseVideosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        session()->put('course_id', $id);
        $title = trans('admin.course_videos');
        $videos = courseVideos::where('course_id', $id)->orderBy('id', 'desc')->get();
        return view('dashboard.Courses.Videos.index', ['title' => $title, 'data' => $videos]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = trans('admin.addVideo');
        return view('dashboard.Courses.Videos.add', ['title' => $title]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(courseVideosRequest $request)
    {
        $course_id = session()->get('course_id');

        $data = $request->except(['_token']);

        $data['video'] = Upload::upload([
            'file'        => 'video',
            'path'        => 'CourseVideos',
            'upload_type' => 'single',
            'delete_file' => '',
        ]);

        $data['course_id'] = $course_id;
        $added = courseVideos::create($data);

        if ($added) {
            # Log to database
            $userType = auth('admin')->check() ? 1 : 2;
            $log = logCreated($userType, auth('admin')->user()->id, 'Courses', 'New Course Video Added', json_encode($data));

            $tokens = admin::pluck('fcm_token')->toArray();
            $data = ['title' => 'Courses', 'content' => 'Course video added', 'title_ar' => 'الدورات التدريبية', 'content_ar' => 'تم اضافة فيديو'];
            firebaseController::notifyUsers($tokens, $data);

            session()->flash('message', trans('admin.add_op_succ'));
        } else {
            session()->flash('error_message', trans('admin.add_op_faild'));
        }

        return redirect(aurl('Courses/' . $course_id . '/Videos'));
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
        $data = courseVideos::find($id);
        $title = trans('admin.edit_video');
        return view('dashboard.Courses.Videos.edit', ['title' => $title, 'data' => $data]);
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
        $oldData = courseVideos::find($id);

        $data = $request->except(['_token', '_method']);

        if ($request->file('video')) {
            $data['video'] = Upload::upload([
                'file'        => 'video',
                'path'        => 'CourseVideos',
                'upload_type' => 'single',
                'delete_file' => $oldData->video,
            ]);
        } else {
            $data['video'] = $oldData->video;
        }

        $update = courseVideos::where('id', $id)->update($data);

        if ($update) {
            # Log to database
            $userType = auth('admin')->check() ? 1 : 2;
            $log = logCreated($userType, auth('admin')->user()->id, 'Courses', 'Course Video Updated', json_encode($data));

            $tokens = admin::pluck('fcm_token')->toArray();
            $data = ['title' => 'Courses', 'content' => 'Course video updated', 'title_ar' => 'الدورات التدريبية', 'content_ar' => 'تم تحديث فيديو'];
            firebaseController::notifyUsers($tokens, $data);

            session()->flash('message', trans('admin.add_op_succ'));
        } else {
            session()->flash('error_message', trans('admin.add_op_faild'));
        }

        return redirect(aurl('Courses/' . $oldData->course_id . '/Videos'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = courseVideos::find($id);
        $delete_video = Upload::delete($data->video);

        $succ_op   = trans('admin.del.op_succ');
        $failed_op = trans('admin.del.op_faild');

        $delete_course = courseVideos::find($id)->delete();

        if ($delete_course) {
            # Log to database
            $userType = auth('admin')->check() ? 1 : 2;
            $log = logDeleted($userType, auth('admin')->user()->id, 'Courses', 'Course video has been deleted', json_encode($data));

            $tokens = admin::pluck('fcm_token')->toArray();
            $data = ['title' => 'Courses', 'content' => 'Course video deleted', 'title_ar' => 'الدورات التدريبية', 'content_ar' => 'تم حذف فيديو'];
            firebaseController::notifyUsers($tokens, $data);


            session()->flash('message', $succ_op);
        } else {
            session()->flash('error_message', $failed_op);
        }

        return redirect()->back();
    }
}
