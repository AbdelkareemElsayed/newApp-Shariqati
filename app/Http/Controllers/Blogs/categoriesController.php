<?php

namespace App\Http\Controllers\Blogs;

use Admins;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Notifications\firebaseController;
use App\Http\Requests\categoryRequest;
use App\Models\dashboard\blog\category;
use App\Models\dashboard\blog\categoryDescription;
use Illuminate\Http\Request;
use App\Http\Controllers\Upload;
use App\Models\dashboard\admins\admin;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class categoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = category::orderBy('id', 'DESC')->with('description')->get();
        return view('dashboard.Blogs.Categories.index', ['data' => $categories, 'title' => trans('admin.allCategories')]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $languages = json_decode(DB::table('settings')->get()[14]->value);

        return view('dashboard.Blogs.Categories.add', ['languages' => $languages, 'title' => trans('admin.addCategory')]);;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(categoryRequest $request)
    {

        $data = $request->except(['_token']);
        $data['image'] = Upload::upload([
            'file'        => 'image',
            'path'        => 'CategoriesImages',
            'upload_type' => 'single',
            'delete_file' => '',
        ]);

        $languages = [];
        foreach ($data as $key => $val) {
            if (Str::startsWith($key, 'name_')) {
                $split = explode('_', $key);
                array_push($languages, $split[1]);
            }
        }

        $add_op_faild     = trans('admin.add_op_faild');
        $add_op_succ      = trans('admin.add_op_succ');
        $category = category::create($data);

        if ($category) {
            foreach ($languages as $language) {
                $category_description = categoryDescription::create([
                    'name' => $request['name_' . $language],
                    'description' => $request['description_' . $language],
                    'language' => $language,
                    'category_id' => $category->id
                ]);
            }

            # Log to database
            $userType = auth('admin')->check() ? 1 : 2;
            $log = logCreated($userType, auth('admin')->user()->id, 'Blogs/Categories', 'New Category Added', json_encode($data));

            $tokens = admin::pluck('fcm_token')->toArray();
            $data = ['title' => 'Categories', 'content' => 'Category added', 'title_ar' => 'التصنيفات', 'content_ar' => 'تم اضافة تصنيف'];
            firebaseController::notifyUsers($tokens, $data);

            session()->flash('message', $add_op_succ);
        } else {
            session()->flash('error_message', $add_op_faild);
        }

        return redirect(aurl('Blogs/Categories'));
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
        $category = category::where('slug', $slug)->with('description')->get();
        return view('dashboard.Blogs.Categories.edit', ['category' => $category, 'title' => trans('admin.editCategory')]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(categoryRequest $request, $slug)
    {
        $data = $request->except(['_token', '_method']);
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

        $languages = [];
        foreach ($data as $key => $val) {
            if (Str::startsWith($key, 'name_')) {
                $split = explode('_', $key);
                array_push($languages, $split[1]);
            }
        }

        foreach ($languages as $language) {
            $category_description = categoryDescription::where('category_id', $oldData[0]->id)
                ->where('language', $language)
                ->update([
                    'name' => $request['name_' . $language],
                    'description' => $request['description_' . $language],
                ]);
        }

        # Log to database
        $userType = auth('admin')->check() ? 1 : 2;
        $log = logUpdated($userType, auth('admin')->user()->id, 'Blogs/Categories', 'Category has been updated', json_encode($data), json_encode($oldData[0]));

        $tokens = admin::pluck('fcm_token')->toArray();
        $data = ['title' => 'Categories', 'content' => 'Category updated', 'title_ar' => 'التصنيفات', 'content_ar' => 'تم تحديث تصنيف'];
        firebaseController::notifyUsers($tokens, $data);

        session()->flash('message', trans('admin.updated_record'));
        return redirect(aurl('Blogs/Categories'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $delete_image = Upload::delete(category::find($id)->image);
        $data = category::find($id);
        $delete = $data->delete();
        $succ_op   = trans('admin.del.op_succ');
        $failed_op = trans('admin.del.op_faild');

        if ($delete) {
            # Log to database
            $userType = auth('admin')->check() ? 1 : 2;
            $log = logDeleted($userType, auth('admin')->user()->id, 'Blogs/Categories', 'Category has been deleted', json_encode($data));

            $tokens = admin::pluck('fcm_token')->toArray();
            $data = ['title' => 'Categories', 'content' => 'Category added', 'title_ar' => 'التصنيفات', 'content_ar' => 'تم حذف تصنيف'];
            firebaseController::notifyUsers($tokens, $data);

            session()->flash('message', $succ_op);
        } else {
            session()->flash('error_message', $failed_op);
        }
        return redirect()->back();
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
        return $slug;
    }
}
