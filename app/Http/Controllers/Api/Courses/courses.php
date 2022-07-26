<?php

namespace App\Http\Controllers\Api\Courses;

use App\Http\Controllers\Controller;
use App\Models\dashboard\Courses\course;
use Illuminate\Http\Request;

class courses extends Controller
{
    public function index($lang)
    {
        $data = course::orderBy('courses.id', 'desc')
            ->with('videos')
            ->get();

        $data = $data->map(function ($item) use ($lang) {
            $item['details'] = $item->detailsApi($lang);
            return $item;
        });

        $data = $data->map(function ($item) use ($lang) {
            $item['points'] = $item->pointsApi($lang);
            return $item;
        });

        return response()->json(['success' => __('admin.data_fetched'), 'data' => $data]);
    }

    public function single($lang, $id)
    {
        $data = course::orderBy('courses.id', 'desc')
            ->with('videos')
            ->where('id', $id)
            ->get();

        $data = $data->map(function ($item) use ($lang) {
            $item['details'] = $item->detailsApi($lang);
            return $item;
        });

        $data = $data->map(function ($item) use ($lang) {
            $item['points'] = $item->pointsApi($lang);
            return $item;
        });

        return response()->json(['success' => __('admin.data_fetched'), 'data' => $data[0]]);
    }
}
