<?php

namespace App\Http\Controllers\Api\Events;

use App\Http\Controllers\Controller;
use App\Models\dashboard\Events\event;
use Carbon\Carbon;
use Illuminate\Http\Request;

class eventsController extends Controller
{
    // Fetch all events
    public function allEvents($lang)
    {
        $data = event::orderBy('events.id', 'desc')
            ->with('keywords')
            ->get();

        $data = $data->map(function ($item) use ($lang) {
            $item['details'] = $item->eventDetail($lang)[0]->only(['name', 'details']);
            return $item;
        });

        return response()->json(['success' => __('admin.data_fetched'), 'data' => $data]);
    }


    // Fetch single event by slug
    public function singleEvent($lang, $slug)
    {
        $data = event::orderBy('events.id', 'desc')
            ->with('keywords')
            ->where('slug', $slug)
            ->get();

        if (count($data) > 0) {
            $data = $data->map(function ($item) use ($lang) {
                $item['details'] = $item->eventDetail($lang)[0]->only(['name', 'details']);
                return $item;
            });

            return response()->json(['success' => __('admin.data_fetched'), 'data' => $data[0]]);
        } else {
            return response()->json(['error' => __('admin.data_fetch_error'), 'data' => __('admin.no_data_available_for_the_slug')]);
        }
    }

    // Get events of a specific date
    function eventsByDate($lang, $date)
    {
        $data = event::orderBy('id', 'desc')
            ->with('keywords')
            ->where('from', $date)
            ->get();

        $data = $data->map(function ($item) use ($lang) {
            $item['details'] = $item->eventDetail($lang)[0]->only(['name', 'details']);
            return $item;
        });

        if (count($data) > 0) {
            return response()->json(['success' => __('admin.data_fetched'), 'data' => $data[0]]);
        } else {
            return response()->json(['success' => __('admin.data_fetched'), 'data' => __('admin.no_events_on_that_day')]);
        }
    }

    // Upcoming events based on current date and now time
    public function upcomingEvents($lang)
    {
        $data = event::orderBy('id', 'desc')
            ->with('keywords')
            ->where('from', '>=', Carbon::now()->format('yyyy-mm-dd'));

        if (Carbon::now()->format('yyyy-mm-dd') == date('Y-m-d')) {
            $data->where('from_time' > strtotime('H:i', time()));
        }

        $data = $data->get();

        $data = $data->map(function ($item) use ($lang) {
            $item['details'] = $item->eventDetail($lang)[0]->only(['name', 'details']);
            return $item;
        });

        if (count($data) > 0) {
            return response()->json(['success' => __('admin.data_fetched'), 'data' => $data[0]]);
        } else {
            return response()->json(['success' => __('admin.data_fetched'), 'data' => __('admin.no_events_on_that_day')]);
        }
    }

    public function currentEvents($lang)
    {
        $data = event::orderBy('id', 'desc')
            ->with('keywords')
            ->where('from', '=', date('Y-m-d'))
            ->where('time_from', '<=', date('H:i', time()))
            ->where('time_to', '>=', date('H:i', time()))
            ->get();

        $data = $data->map(function ($item) use ($lang) {
            $item['details'] = $item->eventDetail($lang)[0]->only(['name', 'details']);
            return $item;
        });

        if (count($data) > 0) {
            return response()->json(['success' => __('admin.data_fetched'), 'data' => $data[0]]);
        } else {
            return response()->json(['success' => __('admin.data_fetched'), 'data' => __('admin.no_events_currently_live')]);
        }
    }
}
