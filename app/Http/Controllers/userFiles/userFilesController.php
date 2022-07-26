<?php

namespace App\Http\Controllers\userFiles;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Notifications\firebaseController;
use App\Http\Controllers\Upload;
use App\Models\dashboard\admins\admin;
use App\Models\dashboard\UserFiles\userFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Pion\Laravel\ChunkUpload\Handler\HandlerFactory;
use Pion\Laravel\ChunkUpload\Receiver\FileReceiver;

class userFilesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        session()->put('user_id', $id);
        $data = userFile::orderBy('id', 'desc')->where('user_id', $id)->get();
        $title = __('admin.userFiles');
        return view('dashboard.Customers.Files.index', ['title' => $title, 'data' => $data]);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = __('admin.addFile');
        return view('dashboard.Customers.Files.add', ['title' => $title]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $this->validate($request, [
            'file'  => 'required|file'
        ]);

        $receiver = new FileReceiver('file', $request, HandlerFactory::classFromRequest($request));

        $fileReceived = $receiver->receive(); // receive file

        if ($fileReceived->isFinished()) { // file uploading is complete / all chunks are uploaded
            $file = $fileReceived->getFile(); // get file
            $extension = $file->getClientOriginalExtension();
            //  $fileName = str_replace('.' . $extension, '', $file->getClientOriginalName()); //file name without extenstion
            $fileName = md5(time()) . '.' . $extension; // a unique file name

            $disk = Storage::disk(config('filesystems.default'));
            $path = $disk->putFileAs('UserFiles', $file, $fileName);

            // delete chunked file
            unlink($file->getPathname());

            # Insert details in DB . . .


            if ($request->has('id')) {
                $delete_file = Upload::delete(userFile::find($request->id)->file);
                $delete_old_record = userFile::find($request->id)->delete();
            }

            $data['user_id'] = session('user_id');
            $data['file'] = 'UserFiles/'.$fileName;
            $data['title'] =  $fileName;

            $add_op_faild     = trans('admin.add_op_faild');
            $add_op_succ      = trans('admin.add_op_succ');

            $file = userFile::create($data);

            if ($file) {
                # Log to database
                $userType = auth('admin')->check() ? 1 : 2;
                $log = logCreated($userType, auth('admin')->user()->id, 'UserFiles', 'New File Added', json_encode($file));

                $tokens = admin::pluck('fcm_token')->toArray();
                $data = ['title' => 'Files', 'content' => 'File added', 'title_ar' => 'الملفات', 'content_ar' => 'تمت اضافة ملف'];

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
        $delete_file = Upload::delete(userFile::find($id)->file);
        $data = userFile::find($id);
        $delete = $data->delete();
        $succ_op   = trans('admin.del.op_succ');
        $failed_op = trans('admin.del.op_faild');

        if ($delete) {
            # Log to database
            $userType = auth('admin')->check() ? 1 : 2;
            $log = logDeleted($userType, auth('admin')->user()->id, 'userFiles', 'File has been deleted', json_encode($data));

            $tokens = admin::pluck('fcm_token')->toArray();
            $data = ['title' => 'Files', 'content' => 'File deleted', 'title_ar' => 'الملفات', 'content_ar' => 'تم حذف ملف'];
            firebaseController::notifyUsers($tokens, $data);


            session()->flash('message', $succ_op);
        } else {
            session()->flash('error_message', $failed_op);
        }

        return redirect()->back();
    }


    public function downloadFile(Request $request)
    {
        $file = userFile::find($request->id);

        if ($request->has('deleteOld')) {
          //   $response = response()->download(asset('storage/'.$file->file) , 200, ['Content-Type: application/pdf']);

            return redirect(asset('storage/'.$file->file));

            Upload::delete($file->file);
        }

        return redirect(asset('storage/'.$file->file));
    }
}
