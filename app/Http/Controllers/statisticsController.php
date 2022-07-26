<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class statisticsController extends Controller
{
    //



    public static function GetLogsTodayCount($actionType)
    {

        $beginOfDay = strtotime("today");
        $endOfDay   = strtotime("tomorrow", $beginOfDay) - 1;

        $data  =  DB::table('logs')->where(['action_type' => $actionType])->whereBetween('time', [$beginOfDay, $endOfDay])->get();
        $count =  count($data);

        return ['data' => $data, 'count' => $count];
    }
    ########################################################################################################################

    public function GetLogCreateTodayCount($module)
    {

        $beginOfDay = strtotime("today");
        $endOfDay   = strtotime("tomorrow", $beginOfDay) - 1;


        $data  =  DB::table('created_log')->where(['module' => $module])->whereBetween('time', [$beginOfDay, $endOfDay])->get();
        $count =  count($data);
        return ['data' => $data, 'count' => $count];
    }

    ########################################################################################################################

    public function GetLogDeleteTodayCount($module)
    {

        $beginOfDay = strtotime("today");
        $endOfDay   = strtotime("tomorrow", $beginOfDay) - 1;


        $data  =  DB::table('deleted_log')->where(['module' => $module])->whereBetween('time', [$beginOfDay, $endOfDay])->get();
        $count =  count($data);
        return ['data' => $data, 'count' => $count];
    }
    ########################################################################################################################

    public function GetLogUpdatedTodayCount($module)
    {

        $beginOfDay = strtotime("today");
        $endOfDay   = strtotime("tomorrow", $beginOfDay) - 1;


        $data  =  DB::table('updated_log')->where(['module' => $module])->whereBetween('time', [$beginOfDay, $endOfDay])->get();
        $count =  count($data);
        return ['data' => $data, 'count' => $count];
    }
    ########################################################################################################################


    public static function TopActiveUsers()
    {
        $now = Carbon::now();

        $startOfMonth = $now->startOfMonth()->timestamp;
        $endOfMonth = $now->endOfMonth()->timestamp;

        $data  =  DB::table('logs')
                     -> join('users','users.id','=','logs.user_id')
                     -> where(['action_type' => 1 , 'user_type' => 2])
                     -> whereBetween('time', [$startOfMonth, $endOfMonth])
                     -> select('users.id','users.name','users.image')
                     -> take(3)
                     -> groupBy('users.id')
                     -> get();
       return $data;
    }

###########################################################################################################################
 public static function TotalUsers($table)
  {
    return DB::table($table)->get()->count();
  }
###########################################################################################################################


public static function TopCountries()
{
    $now = Carbon::now();

    $startOfMonth = $now->startOfMonth()->timestamp;
    $endOfMonth = $now->endOfMonth()->timestamp;

    $data  =  DB::table('logs')
                 -> where(['action_type' => 1 ])
                 -> whereBetween('time', [$startOfMonth, $endOfMonth])
                 -> select('country', DB::raw('count(*) as total'))
                 -> groupBy('country')
                 -> get();
   dd( $data);
}

}
