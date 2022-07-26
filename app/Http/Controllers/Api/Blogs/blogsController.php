<?php

namespace App\Http\Controllers\Api\Blogs;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Upload;
use App\Models\dashboard\blog\blog;
use App\Models\dashboard\blog\blogContent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class blogsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($lang)
    {
        $data = DB::table('blogs')
            ->leftJoin('blog_content', 'blog_content.blog_id', '=', 'blogs.id')
            ->select('blogs.*', 'blog_content.title', 'blog_content.content')
            ->where('blog_content.language', $lang)
            ->get();

        return response()->json(['success' => __('admin.data_fetched'), 'data' => $data], 200);
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
            'title_en' => 'required',
            'title_ar' => 'required',
            'content_en' => 'required',
            'content_ar' => 'required',
            'image' => 'required|mimes:png,jpg,jpeg',
            'category_id' => 'required',
            'slug' => 'required|unique:blogs'
        ]);

        if ($data->fails()) {
            return response()->json(['fail' => __('admin.validation_error'), 'data' => $data->messages()], 400);
        }

        $data = $request->all();
        $data['image'] = Upload::upload([
            'file'        => 'image',
            'path'        => 'BlogsImages',
            'upload_type' => 'single',
            'delete_file' => '',
        ]);

        $data['date'] = time();
        $blog = blog::create($data);
        if ($blog) {
            $content_en = blogContent::create([
                'title' => $request->title_en,
                'content' => $request->content_en,
                'language' => 'en',
                'blog_id' => $blog->id
            ]);

            $content_ar = blogContent::create([
                'title' => $request->title_ar,
                'content' => $request->content_ar,
                'language' => 'ar',
                'blog_id' => $blog->id
            ]);
        }

        # Log to database
        $log = logCreated(1, auth('api')->user()->id, 'Blogs', 'New Blog Added', json_encode($data));

        return response()->json(['success' => __('admin.data_saved_successfully')], 200);
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
    public function update(Request $request, $slug)
    {
        $oldData = blog::where('slug', $slug)->get();
        $data = Validator::make($request->all(), [
            'title_en' => 'required',
            'title_ar' => 'required',
            'content_en' => 'required',
            'content_ar' => 'required',
            'image' => 'nullable|mimes:png,jpg,jpeg',
            'category_id' => 'required',
            'slug' => 'required|unique:blogs,slug,' . $oldData[0]->id
        ]);

        if ($data->fails()) {
            return response()->json(['fail' => __('admin.validation_error'), 'data' => $data->messages()], 400);
        }

        $data = $request->all();


        if ($request->has('image')) {
            $data['image'] = Upload::upload([
                'file'        => 'image',
                'path'        => 'BlogsImages',
                'upload_type' => 'single',
                'delete_file' => $oldData[0]->image,
            ]);
            $blog = blog::where('slug', $slug)->update(['image' => $data['image']]);
        }

        $category_description_en = blogContent::where('blog_id', $oldData[0]->id)
            ->where('language', 'en')
            ->update([
                'title' => $request->title_en,
                'content' => $request->content_en,
            ]);

        $category_description_ar = blogContent::where('blog_id', $oldData[0]->id)->where('language', 'ar')->update([
            'title' => $request->title_ar,
            'content' => $request->content_ar,
        ]);

        # Log to database
        $log = logUpdated(1, auth('admin')->user()->id, 'Blogs', 'Blog has been updated', json_encode($data), json_encode($oldData[0]));

        return response()->json(['success' => __('admin.data_updated_successfully')], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($slug)
    {
        $delete_image = Upload::delete(blog::where('slug', $slug)->get()[0]->image);
        $data = blog::where('slug', $slug)->get()[0];
        $delete = blog::where('slug', $slug)->delete();

        # Log to database
        $userType = auth('admin')->check() ? 1 : 2;
        $log = logDeleted($userType, auth('admin')->user()->id, 'Blogs', 'Blog has been deleted', json_encode($data));

        return response()->json(['success' => __('admin.delete_successfully')], 200);
    }
}
