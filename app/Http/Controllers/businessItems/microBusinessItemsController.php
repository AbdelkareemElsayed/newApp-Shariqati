<?php

namespace App\Http\Controllers\businessItems;

use App\Http\Controllers\Controller;
use App\Models\dashboard\items\items_third_level;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Controllers\Notifications\firebaseController;
use App\Models\dashboard\admins\admin;
use App\Http\Requests\bussinesItemsRequest;



class microBusinessItemsController extends Controller
{


    public function loadItems($id)
    {

       session()->put('sub_item_id',$id);

       $items = items_third_level :: where('second_item_id',$id)->orderBy('id', 'desc')->get();
       $title = 'بنود الاعمال الفرعية';
       return view('dashboard.itemsbusiness.itemsLevelThree.index', ['data' => $items, 'title' => $title]);
    }



        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
     {

       }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'أضافة بند عمل فرعي';
        return view('dashboard.itemsbusiness.itemsLevelThree.add', ['title' => $title]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(bussinesItemsRequest $request)
    {
        $data = $request->except(['_token']);


        # Set Items ID . .
        $data['second_item_id'] = session()->get('sub_item_id');

        // Add Items Level one . . .
        $items = items_third_level::create($data);

         if($items){
            # Log to database
            $userType = auth('admin')->check() ? 1 : 2;
            $log = logCreated($userType, auth('admin')->user()->id, 'Items Level One ', 'New Items Added', json_encode($data));

            $tokens = admin::pluck('fcm_token')->toArray();
            $data = ['title' => 'items', 'content' => 'businessItem added', 'title_ar' => 'بنود الاعمال', 'content_ar' => 'تم اضافة بند جديد'];
            firebaseController::notifyUsers($tokens, $data);

            session()->flash('message', trans('admin.add_op_succ'));
        } else {
            session()->flash('error_message', trans('admin.add_op_faild'));
        }

        return redirect(aurl('LoadMicroItemsLevel/'.session()->get('sub_item_id')));
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
        $data =  items_third_level :: where('id', $id)->orderBy('id', 'desc')->get();

         $title = trans('admin.editItems');
        return view('dashboard.itemsbusiness.itemsLevelThree.edit', ['data' => $data, 'title' => $title ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(bussinesItemsRequest $request, $id)
    {
        $data = $request->except(['_token', '_method']);
        $oldData = items_third_level::find($id);


        // Update Items level one . . .
        $op = items_third_level::where('id', $id)->update($data);

        if($op){
        # Log to database
        $userType = auth('admin')->check() ? 1 : 2;
        $log = logCreated($userType, auth('admin')->user()->id, 'items', 'Items Updated', json_encode($data));

        $tokens = admin::pluck('fcm_token')->toArray();
        $data = ['title' => 'items', 'content' => 'Course updated', 'title_ar' => ' بنود الاعمال', 'content_ar' => 'تم تحديث بنود الاعمال '];
        firebaseController::notifyUsers($tokens, $data);

        session()->flash('message', trans('admin.add_op_succ'));
        }else{
            session()->flash('error_message', trans('admin.error_update'));

        }

        return redirect(aurl('LoadMicroItemsLevel/'.session()->get('sub_item_id')));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
         $data = items_third_level::find($id);
        $succ_op   = trans('admin.del.op_succ');
        $failed_op = trans('admin.del.op_faild');

        $delete_item = items_third_level::find($id)->delete();

        if ($delete_item) {
            # Log to database
            $userType = auth('admin')->check() ? 1 : 2;
            $log = logDeleted($userType, auth('admin')->user()->id, 'businessItems', 'businessItems has been deleted', json_encode($data));

            $tokens = admin::pluck('fcm_token')->toArray();
            $data = ['title' => 'Courses', 'content' => 'item deleted', 'title_ar' => ' البنود  ', 'content_ar' => 'تم حذف بند الاعمال'];
            firebaseController::notifyUsers($tokens, $data);


            session()->flash('message', $succ_op);
        } else {
            session()->flash('error_message', $failed_op);
        }

        return redirect(aurl('LoadMicroItemsLevel/'.session()->get('sub_item_id')));
    }
}
