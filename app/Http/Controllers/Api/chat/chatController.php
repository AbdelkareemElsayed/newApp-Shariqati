<?php

namespace App\Http\Controllers\Api\chat;

use App\Http\Controllers\AppBaseController;
use App\Http\Controllers\Controller;
use App\Models\chat\conversation;
use App\Models\dashboard\admins\admin;
use App\Http\Controllers\Notifications\firebaseController;
use App\Models\chat\conversationMessages;
use Illuminate\Http\Request;

class chatController extends AppBaseController
{

    ##################################################################################################################
    // Fetches all conversations of a user
    public function loadMessages(Request $request)
    {

        # GET CONVERSATION IDS OF THE USER
        $conversationIds = conversation::where('user_id', auth('api')->user()->id )->pluck('id')->toArray();

        # get all messages of the user
        $messages = conversationMessages::whereIn('conversation_id', $conversationIds)->orderBy('id', 'asc');

        $total = $messages->count();

        if ($request->has(['page', 'limit'])) {

            $page  = $request->page;
            $limit = $request->limit;

            # Get Messagess . . .
            $messages = $messages
                ->skip($limit * $page)
                ->take($limit)
                ->get();
        } else {
            # Get Messagess . . .
            $messages = $messages->get();
        }



        return $this->sendResponsePaginate($messages,$total);
    }


    ##################################################################################################################

    // Send Message . . .
    public function sendMessage(Request $request)
    {

        # Validate Request
        $this->validate($request, [
            "message" => "required|max:500|min:1"
        ]);

        # check if conversation exist
        $conversation = conversation::where('user_id', auth('api')->user()->id)->first();

        if ($conversation) {
            # if exist
            $conversation->messages()->create([
                'message' => $request->message,
                'user_id' => auth('api')->user()->id,
                'time'    => time()
            ]);
        } else {
            # if not exist
            $conversation = conversation::create([
                'user_id' => auth('api')->user()->id,
                'time'    => time()
            ]);
            $conversation->messages()->create([
                'message' => $request->message,
                'user_id' => auth('api')->user()->id,
                'time'    => time()
            ]);
        }

        #  Get Admins FCM Tokens . . .
        $tokens = getAdminsToken();

        # Send Messages . . .
        $data = ['message' => $request->message, 'title' => "New Message"];

        firebaseController::sendMessage($tokens, $data);

        return  $this->sendResponse(['message' => __('admin. Message sended')]);
    }


    ##################################################################################################################
}
