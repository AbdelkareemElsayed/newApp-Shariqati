<?php

namespace App\Http\Controllers\Events;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Notifications\firebaseController;
use App\Http\Controllers\Upload;
use App\Http\Requests\eventRequest;
use App\Models\dashboard\admins\admin;
use App\Models\dashboard\Events\event;
use App\Models\dashboard\Events\eventDetails;
use App\Models\dashboard\General\keyword;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class eventsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = event::orderBy('id', 'desc')->with('keywords')->with('eventDetails')->get();
        // dd($data);
        $title = __('admin.all_events');
        return view('dashboard.Events.index', ['data' => $data, 'title' => trans('admin.allEvents')]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = __('admin.add_event');
        return view('dashboard.Events.add', ['title' => $title, 'title' => trans('admin.addEvent')]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(eventRequest $request)
    {
        $data = $request->except(['_token']);

        $data['image'] = Upload::upload([
            'file'        => 'image',
            'path'        => 'EventsImages',
            'upload_type' => 'single',
            'delete_file' => '',
        ]);

        $date = [];
        $date_splitted = explode(' - ', $request->datetime);
        foreach ($date_splitted as $key => $fromto) {
            $date[$key] = explode(' ', $fromto);
        }

        $add_op_faild     = trans('admin.add_op_faild');
        $add_op_succ      = trans('admin.add_op_succ');

        $event = event::create([
            'from' => $date[0][0],
            'to' => $date[1][0],
            'time_from' => $date[0][1],
            'time_to' => $date[1][1],
            'image' => $data['image'],
            'slug' => str_replace(" ", "_", $data['slug']),
            'points' => json_encode($data['points'])
        ]);

        if ($event) {
            $languages = [];
            foreach ($data as $key => $val) {
                if (Str::startsWith($key, 'name_')) {
                    $split = explode('_', $key);
                    array_push($languages, $split[1]);
                }
            }

            foreach ($languages as $language) {
                $event_details = eventDetails::create([
                    'name' => $data['name_' . $language],
                    'details' => $data['details_' . $language],
                    'language' => $language,
                    'event_id' => $event->id
                ]);
            }

            if ($request->filled('keywords')) {
                $keywords = explode(',', $request->keywords);
                foreach ($keywords as $keyword) {
                    $add = keyword::create([
                        'item_id' => $event->id,
                        'keyword' => $keyword,
                        'flag' => 2
                    ]);
                }
            }

            # Log to database
            $userType = auth('admin')->check() ? 1 : 2;
            $log = logCreated($userType, auth('admin')->user()->id, 'Events', 'New Event Added', json_encode($data));

            $tokens = admin::pluck('fcm_token')->toArray();
            $data = ['title' => 'Events', 'content' => 'Event added', 'title_ar' => 'الاحداث', 'content_ar' => 'تم اضافة حدث'];
            firebaseController::notifyUsers($tokens, $data);


            session()->flash('message', $add_op_succ);
        } else {
            session()->flash('error_message', $add_op_faild);
        }

        return redirect(aurl('Events'));
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
        $event = event::where('slug', $slug)->with('keywords')->with('eventDetails')->get();

        // dd($event);
        $keywords = [];
        foreach ($event[0]->keywords as $keyword) {
            array_push($keywords, $keyword->keyword);
        }

        return view('dashboard.Events.edit', ['data' => $event, 'keywords' => $keywords, 'title' => trans('admin.editEvent')]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(eventRequest $request, $slug)
    {
        $data = $request->except(['_token', '_method']);

        $oldData = event::find($request->id);

        if ($request->filled('image')) {
            $data['image'] = Upload::upload([
                'file'        => 'image',
                'path'        => 'EventsImages',
                'upload_type' => 'single',
                'delete_file' => event::find($request->id)->image,
            ]);
        } else {
            $data['image'] = $oldData->image;
        }

        $date = [];
        $date_splitted = explode(' - ', $request->datetime);
        foreach ($date_splitted as $key => $fromto) {
            $date[$key] = explode(' ', $fromto);
        }

        $event = event::where('id', $request->id)->update([
            'from' => $date[0][0],
            'to' => $date[1][0],
            'time_from' => $date[0][1],
            'time_to' => $date[1][1],
            'image' => $data['image'],
            'slug' => str_replace(" ", "_", $data['slug']),
            'points' => json_encode($data['points'])
        ]);

        if ($event) {
            $languages = [];
            foreach ($data as $key => $val) {
                if (Str::startsWith($key, 'name_')) {
                    $split = explode('_', $key);
                    array_push($languages, $split[1]);
                }
            }

            foreach ($languages as $language) {
                $event_details = eventDetails::where('event_id', $request->id)->where('language', $language)->update([
                    'name' => $data['name_' . $language],
                    'details' => $data['details_' . $language],
                ]);
            }

            if ($request->filled('keywords')) {
                $delete_keyword = keyword::where('flag', 2)->where('item_id', $request->id)->delete();
                $keywords = explode(',', $request->keywords);
                foreach ($keywords as $keyword) {
                    if (strlen($keyword) > 0) {
                        $add = keyword::create([
                            'item_id' => $request->id,
                            'keyword' => $keyword,
                            'flag' => 2
                        ]);
                    }
                }
            }

            # Log to database
            $userType = auth('admin')->check() ? 1 : 2;
            $log = logUpdated($userType, auth('admin')->user()->id, 'Events', 'Event has been updated', json_encode($data), json_encode($oldData));

            $tokens = admin::pluck('fcm_token')->toArray();
            $data = ['title' => 'Events', 'content' => 'Event updated', 'title_ar' => 'الاحداث', 'content_ar' => 'تم تحديث حدث'];
            firebaseController::notifyUsers($tokens, $data);


            session()->flash('message', trans('admin.updated_record'));
        } else {
            session()->flash('error_message', trans('admin.updated_record_error'));
        }
        return redirect(aurl('Events'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $data = event::find($id);
        $delete_image = Upload::delete($data->image);
        $delete = $data->delete();
        $succ_op   = trans('admin.del.op_succ');
        $failed_op = trans('admin.del.op_faild');
        if ($delete) {
            # Log to database
            $userType = auth('admin')->check() ? 1 : 2;
            $log = logDeleted($userType, auth('admin')->user()->id, 'Events', 'Event has been deleted', json_encode($data));

            $tokens = admin::pluck('fcm_token')->toArray();
            $data = ['title' => 'Events', 'content' => 'Event deleted', 'title_ar' => 'الاحداث', 'content_ar' => 'تم حذف حدث'];
            firebaseController::notifyUsers($tokens, $data);


            session()->flash('message', $succ_op);
        } else {
            session()->flash('error_message', $failed_op);
        }
        return redirect()->back();
    }
}
