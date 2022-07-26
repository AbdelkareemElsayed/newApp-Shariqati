<?php

namespace App\Http\Controllers;

use Response;


class AppBaseController extends Controller
{
    public function sendResponse($result)
    {
        return Response::json(["data" => $result ] , 200);
    }



    public function sendResponsePaginate($result,$total)
    {
        return Response::json(["data" => $result , 'Total' => $total ] , 200);
    }




    // public function sendError($error, $code = 200)
    // {
    //     return Response::json(ResponseUtil::makeError($error), $code);
    // }



    // public function sendSuccess($message)
    // {
    //     return Response::json([
    //         'success' => true,
    //         'message' => $message
    //     ], 200);
    // }

    // public function sendApiResponse($result, $message)
    // {
    //     $result["message"] = $message;
    //     $result["success"] = true;
    //     return Response::json($result);
    // }

    // public function sendApiError($error, $code = 404, $erroCode = 0)
    // {
    //     if($erroCode == 1){
    //         return Response::json(array("error" => $error, "success" => false, 'error_code' => 1), $code);
    //     }else{
    //         return Response::json(array("error" => $error, "success" => false), $code);
    //     }
    // }



}
