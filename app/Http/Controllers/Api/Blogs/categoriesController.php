<?php

namespace App\Http\Controllers\Api\Blogs;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Upload;
use App\Models\dashboard\blog\Category;
use App\Models\dashboard\blog\CategoryDescription;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class categoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($lang)
    {
        $categories = DB::table('categories')
            ->leftJoin('category_description', 'category_description.category_id', '=', 'categories.id')
            ->select('categories.*', 'category_description.name', 'category_description.description')
            ->where('category_description.language', '=', $lang)
            ->orderBy('id', 'desc')
            ->get();

        return response()->json(['success' => trans('admin.data_fetched'), 'data' => $categories], 200);
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
            'name_en' => 'required',
            'name_ar' => 'required',
            'description_ar' => 'required',
            'description_en' => 'required',
            'image' => 'required|mimes:png,jpg,jpeg',
            'slug' => 'required|unique:categories'
        ]);

        if ($data->fails()) {
            return response()->json([
                'fail' => trans('admin.validation_error'),
                'data' => $data->messages(),
            ], 400);
        }

        $data = $request->all();

        $data['image'] = Upload::upload([
            'file'        => 'image',
            'path'        => 'CategoriesImages',
            'upload_type' => 'single',
            'delete_file' => '',
        ]);

        $category = category::create($data);

        if ($category) {
            $category_description_en = categoryDescription::create([
                'name' => $request->name_en,
                'description' => $request->description_en,
                'language' => 'en',
                'category_id' => $category->id
            ]);

            $category_description_ar = categoryDescription::create([
                'name' => $request->name_ar,
                'description' => $request->description_ar,
                'language' => 'ar',
                'category_id' => $category->id
            ]);
        }

        # Log to database
        $userType = 1;
        $log = logCreated($userType, auth('api')->user()->id, 'Blogs/Categories', 'New Category Added', json_encode($data));

        return response()->json(['success' => 'admin.data_saved_successfully'], 200);
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
        $data = Validator::make($request->all(), [
            'name_en' => 'required',
            'name_ar' => 'required',
            'description_ar' => 'required',
            'description_en' => 'required',
            'image' => 'nullable|mimes:png,jpg,jpeg',
            'slug' => 'required|unique:categories'
        ]);

        if ($data->fails()) {
            return response()->json([
                'fail' => trans('admin.validation_error'),
                'data' => $data->messages(),
            ], 400);
        }

        $data = $request->all();
        $oldData = category::where('slug', $slug)->get();

        if ($request->has('image')) {
            $data['image'] = Upload::upload([
                'file'        => 'image',
                'path'        => 'CategoriesImages',
                'upload_type' => 'single',
                'delete_file' => $oldData[0]->image,
            ]);
            $category = category::where('id', $oldData[0]->id)->update(['image' => $data['image']]);
        }

        $category_description_en = categoryDescription::where('category_id', $oldData[0]->id)
            ->where('language', 'en')
            ->update([
                'name' => $request->name_en,
                'description' => $request->description_en,
            ]);

        $category_description_ar = categoryDescription::where('category_id', $oldData[0]->id)->where('language', 'ar')->update([
            'name'        => $request->name_ar,
            'description' => $request->description_ar,
        ]);

        # Log to database
        $userType = 1;
        $log = logUpdated($userType, auth('api')->user()->id, 'Blogs/Categories', 'Category has been updated', json_encode($data), json_encode($oldData[0]));

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
        $delete_image = Upload::delete(category::where('slug', $slug)->get()[0]->image);
        $data = category::where('slug', $slug)->get()[0];
        $delete = category::where('slug', $slug)->delete();

        # Log to database
        $userType = 1;
        $log = logDeleted($userType, auth('admin')->user()->id, 'Blogs/Categories', 'Category has been deleted', json_encode($data));

        return response()->json(['success' => __('admin.delete_successfully')], 200);
    }

    public function getCategoryBlogs($slug, $lang)
    {
        $data = DB::table('categories')
            ->join('blogs', 'blogs.category_id', '=', 'categories.id')
            ->leftJoin('blog_content', 'blog_content.blog_id', '=', 'blogs.id')
            ->select('blogs.*', 'blog_content.title', 'blog_content.content')
            ->where('categories.slug', $slug)
            ->where('blog_content.language', $lang)
            ->get();

        return response()->json(['success' => __('admin.data_fetched'), 'data' => $data], 200);
    }

    // Generate random slug
    function generateSlug()
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $slug = '';
        for ($i = 0; $i < 10; $i++) {
            $index = rand(0, strlen($characters) - 1);
            $slug .= $characters[$index];
        }
        return response()->json(['data' => $slug], 200);
    }
}
