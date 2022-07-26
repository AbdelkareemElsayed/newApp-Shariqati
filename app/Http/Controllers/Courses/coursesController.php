<?php

namespace App\Http\Controllers\Courses;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Notifications\firebaseController;
use App\Http\Controllers\Upload;
use App\Http\Requests\courseRequest;
use App\Models\dashboard\admins\admin;
use App\Models\dashboard\Courses\course;
use App\Models\dashboard\Courses\courseDetails;
use App\Models\dashboard\Courses\coursePoints;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class coursesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $courses = course::orderBy('id', 'desc')->with('details')->with('points')->get();
        $title = trans('admin.allCourses');
        return view('dashboard.Courses.index', ['data' => $courses, 'title' => $title]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = trans('admin.addCourse');
        return view('dashboard.Courses.add', ['title' => $title]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(courseRequest $request)
    {
        $data = $request->except(['_token']);

        // Upload course image
        if ($request->file('image')) {
            $data['image'] = Upload::upload([
                'file'        => 'image',
                'path'        => 'CoursesImages',
                'upload_type' => 'single',
                'delete_file' => '',
            ]);
        }

        // Upload course promo videp (if existed)
        if ($request->file('promo_video')) {
            $data['promo_url'] = Upload::upload([
                'file'        => 'promo_video',
                'path'        => 'CoursesVideos',
                'upload_type' => 'single',
                'delete_file' => '',
            ]);
        }

        // Add course
        $course = course::create([
            'slug' => $data['slug'],
            'image' => $data['image'],
            'promo_video' => $data['promo_url']
        ]);

        if ($course) {
            $languages = [];

            // Get languages added
            foreach ($data as $key => $val) {
                if (Str::startsWith($key, 'title_')) {
                    $split = explode('_', $key);
                    array_push($languages, $split[1]);
                }
            }


            foreach ($languages as $language) {
                // Add course details
                $course_detail = courseDetails::create([
                    'title' => $data['title_' . $language],
                    'description' => $data['details_' . $language],
                    'language' => $language,
                    'course_id' => $course->id
                ]);

                // Add course points
                if ($data['points_' . $language] != null) {
                    foreach ($data['points_' . $language] as $point) {
                        $course_point = coursePoints::create([
                            'point' => $point,
                            'language' => $language,
                            'course_id' => $course->id,
                        ]);
                    }
                }
            }



            # Log to database
            $userType = auth('admin')->check() ? 1 : 2;
            $log = logCreated($userType, auth('admin')->user()->id, 'Courses', 'New Course Added', json_encode($data));

            $tokens = admin::pluck('fcm_token')->toArray();
            $data = ['title' => 'Courses', 'content' => 'Course added', 'title_ar' => 'الدورات التدريبية', 'content_ar' => 'تم اضافة دورة تدريبية'];
            firebaseController::notifyUsers($tokens, $data);

            session()->flash('message', trans('admin.add_op_succ'));
        } else {
            session()->flash('error_message', trans('admin.add_op_faild'));
        }

        return redirect(aurl('Courses'));
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
        $course = course::with('details')
            ->where('id', $id)
            ->orderBy('id', 'desc')
            ->get();

        $points = coursePoints::where('course_id', $id)->get()->groupBy('language');
        $title = trans('admin.editCourse');
        return view('dashboard.Courses.edit', ['data' => $course, 'title' => $title, 'points' => $points]);
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
        $data = $request->except(['_token', '_method']);
        $oldData = course::find($id);

        // Upload course image
        if ($request->file('image')) {
            $data['image'] = Upload::upload([
                'file'        => 'image',
                'path'        => 'CoursesImages',
                'upload_type' => 'single',
                'delete_file' => $oldData->image,
            ]);
        } else {
            $data['image'] = $oldData->image;
        }

        // Upload course promo video (if existed)
        if ($request->file('promo_video')) {
            $data['promo_url'] = Upload::upload([
                'file'        => 'promo_video',
                'path'        => 'CoursesVideos',
                'upload_type' => 'single',
                'delete_file' => $oldData->promo_video,
            ]);
        } elseif ($request->has('promo_url')) {
            $data['promo_url'] = $data['promo_url'];
        } else {
            $data['promo_url'] =  $oldData->promo_video;
        }

        // Update course
        $course = course::where('id', $id)->update([
            'slug' => $data['slug'],
            'image' => $data['image'],
            'promo_video' => $data['promo_url']
        ]);


        $languages = [];

        // Get languages added
        foreach ($data as $key => $val) {
            if (Str::startsWith($key, 'title_')) {
                $split = explode('_', $key);
                array_push($languages, $split[1]);
            }
        }

        foreach ($languages as $language) {
            // Update course details
            $delete_old_desc = courseDetails::where(['course_id' => $id, 'language' => $language])->delete();

            $course_detail = courseDetails::create([
                'title' => $data['title_' . $language],
                'description' => $data['details_' . $language],
                'language' => $language,
                'course_id' => $id,
            ]);

            // Update course points
            if ($data['points_' . $language] != null) {
                $delete_old_points = coursePoints::where(['course_id' => $id, 'language' => $language])->delete();
                foreach ($data['points_' . $language] as $point) {
                    $course_point = coursePoints::create([
                        'point' => $point,
                        'language' => $language,
                        'course_id' => $id,
                    ]);
                }
            }
        }

        # Log to database
        $userType = auth('admin')->check() ? 1 : 2;
        $log = logCreated($userType, auth('admin')->user()->id, 'Courses', 'Course Updated', json_encode($data));

        $tokens = admin::pluck('fcm_token')->toArray();
        $data = ['title' => 'Courses', 'content' => 'Course updated', 'title_ar' => 'الدورات التدريبية', 'content_ar' => 'تم تحديث دورة تدريبية'];
        firebaseController::notifyUsers($tokens, $data);

        session()->flash('message', trans('admin.add_op_succ'));


        return redirect(aurl('Courses'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = course::with('details')->where('id', $id)->get()[0];
        $delete_image = Upload::delete($data->image);
        $delete_image = Upload::delete($data->promo_video);

        $succ_op   = trans('admin.del.op_succ');
        $failed_op = trans('admin.del.op_faild');

        $delete_course = course::find($id)->delete();

        if ($delete_course) {
            # Log to database
            $userType = auth('admin')->check() ? 1 : 2;
            $log = logDeleted($userType, auth('admin')->user()->id, 'Courses', 'Course has been deleted', json_encode($data));

            $tokens = admin::pluck('fcm_token')->toArray();
            $data = ['title' => 'Courses', 'content' => 'Course deleted', 'title_ar' => 'الدورات التدريبية', 'content_ar' => 'تم حذف دورة تدريبية'];
            firebaseController::notifyUsers($tokens, $data);


            session()->flash('message', $succ_op);
        } else {
            session()->flash('error_message', $failed_op);
        }

        return redirect()->back();
    }
}
