<?php

namespace App\Http\Controllers\Blogs;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Upload;
use App\Http\Requests\blogRequest;
use App\Models\dashboard\blog\category;
use App\Models\dashboard\blog\blog;
use App\Models\dashboard\blog\blogContent;
use App\Models\dashboard\General\keyword;
use App\Http\Controllers\Notifications\firebaseController;
use App\Models\dashboard\admins\admin;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class blogsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $blogs = Blog::orderBy('blogs.id', 'desc')
            ->with('content')
            ->with('keywords')
            ->get();
        return view('dashboard.Blogs.index', ['data' => $blogs, 'title' => trans('admin.allBlogs')]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = category::all();
        return view('dashboard.Blogs.add', ['categories' => $categories, 'title' => trans('admin.addBlog')]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(blogRequest $request)
    {
        $data = $request->except(['_method']);
        $data['image'] = Upload::upload([
            'file'        => 'image',
            'path'        => 'BlogsImages',
            'upload_type' => 'single',
            'delete_file' => '',
        ]);

        $data['date'] = time();

        $languages = [];
        foreach ($data as $key => $val) {
            if (Str::startsWith($key, 'title_')) {
                $split = explode('_', $key);
                array_push($languages, $split[1]);
            }
        }

        $add_op_faild     = trans('admin.add_op_faild');
        $add_op_succ      = trans('admin.add_op_succ');
        $blog = blog::create($data);

        if ($blog) {
            if ($request->filled('keywords')) {
                $keywords = explode(',', $request->keywords);
                foreach ($keywords as $keyword) {
                    $add = keyword::create(['item_id' => $blog->id, 'keyword' => $keyword, 'flag' => 1]);
                }
            }

            foreach ($languages as $language) {
                $blog_content = blogContent::create([
                    'title' => $request['title_' . $language],
                    'content' => $request['content_' . $language],
                    'language' => $language,
                    'blog_id' => $blog->id
                ]);
            }

            $tokens = admin::pluck('fcm_token')->toArray();
            $data = ['title' => 'Blogs', 'content' => 'لآlog post added', 'title_ar' => 'المدونات', 'content_ar' => 'تم اضافة مدونة'];
            firebaseController::notifyUsers($tokens, $data);


            # Log to database
            $userType = 1;
            $log = logCreated($userType, auth('admin')->user()->id, 'Blogs', 'New Blog Added', json_encode($data));

            session()->flash('message', $add_op_succ);
        } else {
            session()->flash('error_message', $add_op_faild);
        }

        return redirect(aurl('Blogs'));
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
    public function edit($slug)
    {
        $categories = category::all();
        $blog = Blog::where('slug', $slug)->with('content')->get();
        return view('dashboard.Blogs.edit', ['categories' => $categories, 'blog' => $blog, 'title' => trans('admin.editBlog')]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(blogRequest $request, $slug)
    {
        $data = $request->except(['_token', '_method']);
        $oldData = blog::where('slug', $slug)->get();

        if ($request->has('image')) {
            $data['image'] = Upload::upload([
                'file'        => 'image',
                'path'        => 'BlogsImages',
                'upload_type' => 'single',
                'delete_file' => $oldData[0]->image,
            ]);
            $blog = blog::where('id', $oldData[0]->id)->update(['image' => $data['image']]);
        }

        if ($request->filled('keywords')) {
            $delete = keyword::where('blog_id', $oldData[0]->id)->delete();
            $keywords = explode(',', $request->keywords);
            foreach ($keywords as $keyword) {
                $add = keyword::create(['item_id' => $blog->id, 'keyword' => $keyword, 'flag' => 1]);
            }
        }

        $languages = [];
        foreach ($data as $key => $val) {
            if (Str::startsWith($key, 'title_')) {
                $split = explode('_', $key);
                array_push($languages, $split[1]);
            }
        }

        foreach ($languages as $language) {
            $blog_content = blogContent::where('blog_id', $oldData[0]->id)
                ->where('language', $language)
                ->update([
                    'title' => $request['title_' . $language],
                    'content' => $request['content_' . $language],
                ]);
        }

        # Log to database
        $userType = 1;
        $log = logUpdated($userType, auth('admin')->user()->id, 'Blogs', 'Blog has been updated', json_encode($data), json_encode($oldData[0]));

        $tokens = admin::pluck('fcm_token')->toArray();
        $data = ['title' => 'Blogs', 'content' => 'Blog post updated', 'title_ar' => 'المدونات', 'content_ar' => 'تم تحديث مدونة'];
        firebaseController::notifyUsers($tokens, $data);

        session()->flash('message', trans('admin.updated_record'));
        return redirect(aurl('Blogs'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $delete_image = Upload::delete(blog::find($id)->image);
        $data = blog::find($id);
        $delete = $data->delete();
        $succ_op   = trans('admin.del.op_succ');
        $failed_op = trans('admin.del.op_faild');

        if ($delete) {
            # Log to database
            $userType = 1;
            $log = logDeleted($userType, auth('admin')->user()->id, 'Blogs', 'Blog has been deleted', json_encode($data));

            $tokens = admin::pluck('fcm_token')->toArray();
            $data = ['title' => 'Blogs', 'content' => 'Blog post deleted', 'title_ar' => 'المدونات', 'content_ar' => 'تم حذف مدونة'];
            firebaseController::notifyUsers($tokens, $data);

            session()->flash('message', $succ_op);
        } else {
            session()->flash('error_message', $failed_op);
        }

        return redirect()->back();
    }
}
