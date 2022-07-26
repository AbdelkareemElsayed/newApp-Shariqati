<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Notifications\firebaseController;
use App\Http\Controllers\Upload;
use App\Models\dashboard\admins\admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class settingsController extends Controller
{

    public function settingsPage()
    {
        $settings = DB::table('settings')->get();
        return view('dashboard.Settings.settings', ['data' => $settings]);
    }


    public function updateSettings(Request $request)
    {

        $data = $request->except(['_token','debug','languages','is_value_added_tax']);

        $oldData = DB::table('settings')->get();

        if ($request->has('logo')) {
            $settings = DB::table('settings')->get();
            $data['logo'] = Upload::upload([
                'file'        => 'logo',
                'path'        => 'Logos',
                'upload_type' => 'single',
                'delete_file' => $settings[3]->value,
            ]);
          }



          if ($request->has('invoice_waterMark')) {
            $settings = DB::table('settings')->get();
            $data['invoice_waterMark'] = Upload::upload([
                'file'        => 'invoice_waterMark',
                'path'        => 'invoice_waterMark',
                'upload_type' => 'single',
                'delete_file' => $settings[3]->value,
            ]);
          }

          
        # Update Lang && debug &
        if ($request->has('languages')) {
            $update = DB::table('settings')->where('key', 'languages')->update(['value' => $request->languages]);
         }elseif (!$request->filled('languages')) {
            $update = DB::table('settings')->where('key', 'languages')->update(['value' => NULL]);
         }


        if ($request->has('debug')) {
            $update = DB::table('settings')->where('key', 'debug')->update(['value' => 1]);
          } elseif (!$request->has('debug')) {
           $update = DB::table('settings')->where('key', 'debug')->update(['value' => 0]);
        }


          if ($request->has('is_value_added_tax')) {
            $update = DB::table('settings')->where('key', 'is_value_added_tax')->update(['value' => 1]);
          } elseif (!$request->has('is_value_added_tax')) {
           $update = DB::table('settings')->where('key', 'is_value_added_tax')->update(['value' => 0]);
          }


        foreach ($data as $key => $val) {
           # Update the settings
           $update = DB::table('settings')->where('key', $key)->update(['value' => $val]);
        }

        # Log to database
        $userType = auth('admin')->check() ? 1 : 2;
        $log = logUpdated($userType, auth('admin')->user()->id, 'Settings', 'Settings have been updated', json_encode($data), json_encode($oldData[0]));

        $tokens = admin::pluck('fcm_token')->toArray();
        $data = ['title' => 'Settings', 'content' => 'Settings updated', 'title_ar' => 'الاعدادات', 'content_ar' => 'تم تحديث الاعدادات'];
        firebaseController::notifyUsers($tokens, $data);

        return redirect(aurl('Settings'));
    }




    # Load All Data . . .
    public static function loadCompanyInfo()
    {
        return   DB::table('settings')->get();
    }


}
