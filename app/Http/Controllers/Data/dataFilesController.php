<?php

namespace App\Http\Controllers\Data;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Notifications\firebaseController;
use App\Http\Controllers\Upload;
use App\Http\Requests\dataFileRequest;
use App\Models\dashboard\admins\admin;
use App\Models\dashboard\Data\accessRequests;
use App\Models\dashboard\Data\data;
use App\Models\dashboard\Data\dataFiles;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Pion\Laravel\ChunkUpload\Handler\HandlerFactory;
use Pion\Laravel\ChunkUpload\Receiver\FileReceiver;


class dataFilesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        session()->put('data_id', $id);
        $data = dataFiles::where('data_id', $id)->orderBy('id', 'desc')->get();
        $title = __('admin.all_data_files');

        if (Auth::guard('admin')->check()) {
            $customers = User::orderBy('id', 'desc')->get();
            return view('dashboard.Data.Files.index-admin', ['title' => $title, 'data' => $data, 'customers' => $customers]);
        } else {
            return view('dashboard.Data.Files.index-user', ['title' => $title, 'data' => $data]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.Data.Files.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(dataFileRequest $request)
    {

        $receiver = new FileReceiver('file', $request, HandlerFactory::classFromRequest($request));

        $fileReceived = $receiver->receive(); // receive file

        if ($fileReceived->isFinished()) { // file uploading is complete / all chunks are uploaded
            $file = $fileReceived->getFile(); // get file
            $extension = $file->getClientOriginalExtension();
            //  $fileName = str_replace('.' . $extension, '', $file->getClientOriginalName()); //file name without extenstion
            $fileName = md5(time()) . '.' . $extension; // a unique file name

            $disk = Storage::disk(config('filesystems.default'));
            $path = $disk->putFileAs('DataFiles', $file, $fileName);

            // delete chunked file
            unlink($file->getPathname());

            # Insert details in DB . . .

            $data_id = session()->get('data_id');
            $data['data_id'] = $data_id;
            $data['file']  = 'DataFiles/'.$fileName; 
            $data['name']  = $fileName; 
          

            $added = dataFiles::create($data);

            if ($added) {
                  # Log to database
            $userType = auth('admin')->check() ? 1 : 2;
            $log = logCreated($userType, auth('admin')->user()->id, 'Data/Files', 'New File Added', json_encode($data));

            $tokens = admin::pluck('fcm_token')->toArray();
            $data = ['title' => 'File', 'content' => 'File added', 'title_ar' => 'الملفات', 'content_ar' => 'تم اضافة ملف'];
            firebaseController::notifyUsers($tokens, $data);


            }
            return [
                'path' => asset('storage/' . $path),
                'filename' => $fileName
            ];
        }

        // otherwise return percentage informatoin
        $handler = $fileReceived->handler();
        return [
            'done' => $handler->getPercentageDone(),
            'status' => true
        ];








        // $data = $request->except(['_token']);
        // $data['file'] = Upload::upload([
        //     'file'        => 'file',
        //     'path'        => 'DataFiles',
        //     'upload_type' => 'single',
        //     'delete_file' => '',
        // ]);


        // $data_id =        session()->get('data_id');

        // $data['data_id'] = $data_id;
        // $add_op_faild     = trans('admin.add_op_faild');
        // $add_op_succ      = trans('admin.add_op_succ');
        // $added = dataFiles::create($data);

        // if ($added) {
        //     # Log to database
        //     $userType = auth('admin')->check() ? 1 : 2;
        //     $log = logCreated($userType, auth('admin')->user()->id, 'Data/Files', 'New File Added', json_encode($data));

        //     $tokens = admin::pluck('fcm_token')->toArray();
        //     $data = ['title' => 'File', 'content' => 'File added', 'title_ar' => 'الملفات', 'content_ar' => 'تم اضافة ملف'];
        //     firebaseController::notifyUsers($tokens, $data);


        //     session()->flash('message', $add_op_succ);
        // } else {
        //     session()->flash('error_message', $add_op_faild);
        // }

        // return redirect(aurl('Files/' . $data_id));





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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $fileName = dataFiles::find($id)->file; 
       
        $data = dataFiles::find($id);
        $delete = $data->delete();
        $succ_op   = trans('admin.del.op_succ');
        $failed_op = trans('admin.del.op_faild');

        if ($delete) {
       
       
            Upload::delete($fileName);
       
            # Log to database
            $userType = auth('admin')->check() ? 1 : 2;
            $log = logDeleted($userType, auth('admin')->user()->id, 'Data/Files', 'File has been deleted', json_encode($data));

            $tokens = admin::pluck('fcm_token')->toArray();
            $data = ['title' => 'File', 'content' => 'File deleted', 'title_ar' => 'الملفات', 'content_ar' => 'تم حذف ملف'];
            firebaseController::notifyUsers($tokens, $data);

            session()->flash('message', $succ_op);
        } else {
            session()->flash('error_message', $failed_op);
        }

        return redirect()->back();
    }

    public function filePermissions(Request $request, $id)
    {
        // Delete Old Permissions
        $delete = DB::table('user_file_permissions')->where('file_id', $id)->delete();

        // Add New Permissions
        if ($request->has('users') > 0) {
            foreach ($request->users as $user) {
                $add = DB::table('user_file_permissions')->insert(['file_id' => $id, 'user_id' => $user]);
            }
        }

        $add_op_succ      = trans('admin.add_op_succ');
        session()->flash('message', $add_op_succ);
        return redirect()->back();
    }

    public function requestAccess($user_id, $file_id)
    {
        $data = [
            'user_id' => $user_id,
            'file_id' => $file_id,
            'status' => 0
        ];
        $add_to_requests = accessRequests::create($data);
        return redirect()->back();
    }
}
