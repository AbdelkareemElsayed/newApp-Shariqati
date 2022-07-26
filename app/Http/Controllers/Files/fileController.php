<?php

namespace App\Http\Controllers\Files;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Upload;
use App\Models\dashboard\Files\file;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Storage;
use Pion\Laravel\ChunkUpload\Handler\HandlerFactory;
use Pion\Laravel\ChunkUpload\Receiver\FileReceiver;

class fileController extends Controller
{
    //

    public function index()
    {

        $data = file::with('uploadedBy')->whereuserId(auth('admin')->user()->id)->simplePaginate(10);
        return view('Dashboard.Files.index', ['data' => $data, 'title' => __('admin.List Uploaded Files')]);
    }

    ###############################################################################################################

    public function create()
    {
        return view('Dashboard.Files.add',['title' => __('admin.upload File')]);
    }

    ###############################################################################################################


    public static function store(Request $request)
    {
        $receiver = new FileReceiver('file', $request, HandlerFactory::classFromRequest($request));

        if (!$receiver->isUploaded()) {
            // file not uploaded
            session()->flash('error_message', __('admin.error in Uploading'));
            return back();
        } else {

            $fileReceived = $receiver->receive(); // receive file


            if ($fileReceived->isFinished()) { // file uploading is complete / all chunks are uploaded
                $file = $fileReceived->getFile(); // get file
                $extension = $file->getClientOriginalExtension();
                //  $fileName = str_replace('.' . $extension, '', $file->getClientOriginalName()); //file name without extenstion
                $fileName = md5(time()) . '.' . $extension; // a unique file name

                $disk = Storage::disk(config('filesystems.default'));
                $path = $disk->putFileAs('Files', $file, $fileName);

                // delete chunked file
                unlink($file->getPathname());

                # Insert details in DB . . .
                file::create(['user_id' => auth('admin')->user()->id, 'name' => $fileName]);
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







    }

    ###############################################################################################################

    public function destroy($id)
    {
        # Get Data . . . 
        $data =  file :: find($id); 
       
        # Delete Raw . . . 
        $op =   file::where(['id' => $id, 'user_id' => auth('admin')->user()->id])->delete();

        $succ_op   = trans('admin.del.op_succ');
        $failed_op = trans('admin.del.op_faild');

        if ($op) {
 
            Upload :: delete('Files/'.$data->name);

            session()->flash('message', $succ_op);
        } else {
            session()->flash('error_message', $failed_op);
        }
        return back();
    }
    ###############################################################################################################
}
