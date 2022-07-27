<?php

namespace App\Http\Controllers\Notifications;

use Kutia\Larafirebase\Facades\Larafirebase;

use App\Http\Controllers\Controller;
use App\Models\dashboard\admins\admin;
use App\Models\dashboard\Notifications\notification;
use Illuminate\Http\Request;

class firebaseController extends Controller
{
    public function storeToken(Request $request)
    {
        $update_token = admin::where('id', auth('admin')->user()->id)->update(['fcm_token' => $request->token]);
        return response()->json(['Success' => 'Token saved']);
    }

    public static function notifyUsers($tokens, $data)
    {
        foreach ($tokens as $token) {
            $user = admin::where('fcm_token', $token)->get()[0];

            $notification = notification::create([
                'user_id' => $user->id,
                'title' => $data['title'],
                'content' => $data['content'],
                'title_ar' => $data['title_ar'],
                'content_ar' => $data['content_ar'],
            ]);

            if ($notification) {
                if (session()->get('lang') == 'ar') {
                    Larafirebase::withTitle($data['title_ar'])
                        ->withBody($data['content_ar'])
                        ->sendMessage([$token]);
                } else {
                    Larafirebase::withTitle($data['title'])
                        ->withBody($data['content'])
                        ->sendMessage([$token]);
                }
            }
        }
    }



    public static function sendMessage($tokens, $data)
    {
        foreach ($tokens as $token) {
            $user = admin::where('fcm_token', $token)->get()[0];

            $notification = notification::create([

                'message' => $data['message'],

            ]);

            if ($notification) {
                if (session()->get('lang') == 'ar') {
                    Larafirebase::withTitle($data['title_ar'])
                        ->withBody($data['message'])
                        ->sendMessage([$token]);
                } else {
                    Larafirebase::withTitle($data['title'])
                        ->withBody($data['message'])
                        ->sendMessage([$token]);
                }
            }
        }
    }



}
