<?php

namespace App\Http\Controllers\Api\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class settingsController extends Controller
{
    public function settings()
    {
        $settings = DB::table('settings')->get();
        return response()->json(['success' => __('admin.data_fetch'), 'data' => $settings]);
    }
}
