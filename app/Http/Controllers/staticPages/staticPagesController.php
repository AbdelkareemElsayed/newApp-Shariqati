<?php

namespace App\Http\Controllers\staticPages;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Notifications\firebaseController;
use App\Http\Controllers\Upload;
use App\Http\Requests\staticPagesRequest;
use App\Models\dashboard\admins\admin;
use App\Models\dashboard\staticpages\staticPages;
use App\Models\dashboard\staticpages\staticPagesContent;
use App\Models\dashboard\staticpages\staticPagesKeys;
use Illuminate\Support\Str;

class staticPagesController extends Controller
{

    ################################################################################################################################
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pages = staticPages::orderBy('id', 'desc')
            ->with('content')
            ->with('keywords')
            ->get();
        return view('dashboard.staticPages.index', ['data' => $pages, 'title' => trans('admin.listStaticPages')]);
    }

    ################################################################################################################################
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.staticPages.add', ['title' => trans('admin.addStaticPages')]);
    }

    ################################################################################################################################
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(staticPagesRequest $request)
    {
        $data = $request->except(['_method']);

        $image = Upload::upload([
            'file'        => 'image',
            'path'        => 'staticPages',
            'upload_type' => 'single',
            'delete_file' => '',
        ]);

        # Create Slug . . . 
        $slug = str::slug($request->tag_title, '-');



        $page = staticPages::create(['tag_title' => $request->tag_title, 'slug' => $slug, 'image' => $image]);

        # Insert Title && Content . . .
        foreach (languages() as $language) {
            $page_content = staticPagesContent::create([

                'title' => $request['title_' . $language],
                'content' => $request['content_' . $language],
                'lang' => $language,
                'page_id' => $page->id
            ]);

            # Insert KeyWords . . . 
            foreach (explode(',', $request->keywords) as $key => $value) {
                # code...
                staticPagesKeys::create([
                    "page_id" => $page->id,
                    "key"     => trim($value)
                ]);
            }
        }

        $add_op_faild     = trans('admin.add_op_faild');
        $add_op_succ      = trans('admin.add_op_succ');
        if ($page) {
            # Log to database
            $userType = auth('admin')->check() ? 1 : 2;
            $log = logCreated($userType, auth('admin')->user()->id, 'StaticPages', 'New Page Added', json_encode($page));

            $tokens = admin::pluck('fcm_token')->toArray();
            $data = ['title' => 'Static Pages', 'content' => 'Page added', 'title_ar' => 'الصفحات الثابتة', 'content_ar' => 'تم اضافة صفحة'];
            firebaseController::notifyUsers($tokens, $data);


            session()->flash('message', $add_op_succ);
        } else {
            session()->flash('error_message', $add_op_faild);
        }


        return redirect(aurl('StaticPages'));
    }

    ################################################################################################################################
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

    ################################################################################################################################
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($slug)
    {
        $staticPages = staticPages::where('slug', $slug)->with('content')->with('keywords')->get();
        return view('dashboard.staticPages.edit', ['data' => $staticPages, 'title' => trans('admin.editStaticPages')]);
    }
    ################################################################################################################################

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(staticPagesRequest $request, $id)
    {
        $data = $request->except(['_token', '_method']);


        $oldData = staticPages::find($id);
        # Get Old Image . . . 
        $image = staticPages::find($id)->image;

        if ($request->has('image')) {
            $image = Upload::upload([
                'file'        => 'image',
                'path'        => 'BlogsImages',
                'upload_type' => 'single',
                'delete_file' => $image,
            ]);
        } else {
            $image = $image;
        }

        # Create Slug . . . 
        $slug = str::slug($request->tag_title, '-');

        $page = staticPages::find($id)->update(['slug' => $slug, 'tag_title' => $request->tag_title, 'image' => $image]);


        if ($request->keywords) {
            $delete = staticPagesKeys::where('page_id', $id)->delete();
            $keywords = explode(',', $request->keywords);
            foreach ($keywords as $keyword) {
                $add = staticPagesKeys::create(['page_id' => $id, 'key' => $keyword]);
            }
        }


        foreach (languages() as $language) {
            $page_content = staticPagesContent::where('page_id', $id)
                ->where('lang', $language)
                ->update([
                    'title' => $request['title_' . $language],
                    'content' => $request['content_' . $language],
                ]);
        }

        if ($page_content) {
            # Log to database
            $userType = auth('admin')->check() ? 1 : 2;
            $log = logUpdated($userType, auth('admin')->user()->id, 'Static Pages', 'Page has been updated', json_encode($data), json_encode($oldData));

            $tokens = admin::pluck('fcm_token')->toArray();
            $data = ['title' => 'Static Pages', 'content' => 'Page updated', 'title_ar' => 'الصفحات الثابتة', 'content_ar' => 'تم تحديث صفحة'];
            firebaseController::notifyUsers($tokens, $data);


            session()->flash('message', trans('admin.updated_record'));
        } else {
            session()->flash('error_message', trans('admin.updated_record_error'));
        }
        return redirect(aurl('StaticPages'));
    }


    ################################################################################################################################

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $delete_image = Upload::delete(staticPages::find($id)->image);
        $data = staticPages::find($id);
        $op = $data->delete();

        $succ_op   = trans('admin.del.op_succ');
        $failed_op = trans('admin.del.op_faild');

        if ($op) {
            # Log to database
            $userType = auth('admin')->check() ? 1 : 2;
            $log = logDeleted($userType, auth('admin')->user()->id, 'Static Pages', 'Page has been deleted', json_encode($data));

            $tokens = admin::pluck('fcm_token')->toArray();
            $data = ['title' => 'Static Pages', 'content' => 'Page deleted', 'title_ar' => 'الصفحات الثابتة', 'content_ar' => 'تم حذف صفحة'];
            firebaseController::notifyUsers($tokens, $data);


            session()->flash('message', $succ_op);
        } else {
            session()->flash('error_message', $failed_op);
        }
        return redirect(aurl('StaticPages'));
    }
    ################################################################################################################################
}
