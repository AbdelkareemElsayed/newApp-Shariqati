<?php

namespace App\Http\Controllers\Languages;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Notifications\firebaseController;
use App\Http\Controllers\Upload;
use App\Http\Requests\languageRequest;
use App\Models\dashboard\admins\admin;
use App\Models\dashboard\Languages\language;
use Illuminate\Http\Request;

class languagesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = language::orderBy('id', 'desc')->get();
        $title = trans('admin.languages');
        return view('dashboard.Languages.index', ['data' => $data, 'title' => $title]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = __('admin.add_new_language');
        return view('dashboard.Languages.add', ['title' => $title]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(languageRequest $request)
    {


        $data = $request->except(['_token']);

        if ($request->has('icon')) {
            $data['icon'] = Upload::upload([
                'file'        => 'icon',
                'path'        => 'LanguagesIcons',
                'upload_type' => 'single',
                'delete_file' => '',
            ]);
        }

        $add_op_faild     = trans('admin.add_op_faild');
        $add_op_succ      = trans('admin.add_op_succ');
        $add = language::create($data);
        if ($add) {
            # Log to database
            $userType = auth('admin')->check() ? 1 : 2;
            $log = logCreated($userType, auth('admin')->user()->id, 'Languages', 'New Language Added', json_encode($data));

            $tokens = admin::pluck('fcm_token')->toArray();
            $data = ['title' => 'Languages', 'content' => 'Language added', 'title_ar' => 'اللغات', 'content_ar' => 'تم اضافة لغة'];
            firebaseController::notifyUsers($tokens, $data);

            session()->flash('message', $add_op_succ);
        } else {
            session()->flash('error_message', $add_op_faild);
        }

        return redirect(aurl('Languages'));
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
        $title = __('admin.edit_language');
        $language = language::find($id);
        return view('dashboard.Languages.edit', ['title' => $title, 'data' => $language]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(languageRequest $request, $id)
    {
        $data = $request->except(['_token', '_method']);
        $oldData = language::find($id);

        if ($request->has('icon')) {
            $data['icon'] = Upload::upload([
                'file'        => 'image',
                'path'        => 'LanguagesIcons',
                'upload_type' => 'single',
                'delete_file' => language::find($id)->icon,
            ]);
        }

        $updated = language::where('id', $id)->update($data);
        if ($updated) {
            # Log to database
            $userType = auth('admin')->check() ? 1 : 2;
            $log = logUpdated($userType, auth('admin')->user()->id, 'Data', 'Data Folder has been updated', json_encode($data), json_encode($oldData));

            $tokens = admin::pluck('fcm_token')->toArray();
            $data = ['title' => 'Languages', 'content' => 'Language updated', 'title_ar' => 'اللغات', 'content_ar' => 'تم تحديث لغة'];
            firebaseController::notifyUsers($tokens, $data);

            session()->flash('message', trans('admin.updated_record'));
        } else {
            session()->flash('error_message', trans('admin.updated_record_error'));
        }
        return redirect(aurl('Languages'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $delete_image = Upload::delete(language::find($id)->icon);
        $data = language::find($id);
        $delete = $data->delete();
        $succ_op   = trans('admin.del.op_succ');
        $failed_op = trans('admin.del.op_faild');
        if ($delete) {
            # Log to database
            $userType = auth('admin')->check() ? 1 : 2;
            $log = logDeleted($userType, auth('admin')->user()->id, 'Languages', 'Language has been deleted', json_encode($data));

            $tokens = admin::pluck('fcm_token')->toArray();
            $data = ['title' => 'Languages', 'content' => 'Language deleted', 'title_ar' => 'اللغات', 'content_ar' => 'تم حذف لغة'];
            firebaseController::notifyUsers($tokens, $data);


            session()->flash('message', $succ_op);
        } else {
            session()->flash('error_message', $failed_op);
        }

        return redirect()->back();
    }
}
