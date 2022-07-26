<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use  App\Http\Requests\UserReport;
use PDF;

class StatisticsController extends Controller
{
    //


    public function generate_pdf()
    {
      $pdf = PDF::loadView('dashboard.statistics.document', session()->get('reportData'));
      return $pdf->stream('document.pdf');
    }



  public function index()
  {

    return view('dashboard.statistics.Users',['title' => __('userStatistics')]);
  }


    ############################################################################################################################
    public function UserStatistice(UserReport $request)
    {

        # Result Container . . .
        $result = [];

        $from = strtotime($request->from);
        $to   = strtotime($request->to);

        if($from == $to){
            $to = strtotime("tomorrow", $from) - 1;
        }

        # Get Login Satatistics . . .
        $result['logins'] = $this->GetLogsTodayCount(1, $from, $to);

        # Get Register Statistics . . .
        $result['register'] = $this->GetLogsTodayCount(3, $from, $to);

        # Get LogOut Statistics . . .
        $result['logout'] = $this->GetLogsTodayCount(2, $from, $to);

        # Get Top 10 Active User . . .
        $result['topUsers'] = $this->TopActiveUsers($from, $to);

        # Get Countries Of Users Vists . . .
        $result['countries'] = $this->TopCountries($from, $to);

        # Set Session Data . . .
        session()->flash('data' , $result);

        session()->put('reportData' , $result);

        # Set From session  . . .
        session()->flash('from' , $request->from);

        # Set TO session  . . .
        session()->flash('to' , $request->to);


        return redirect(aurl('Report/Statistics/Users'));
    }

    ############################################################################################################################
    public function GetLogsTodayCount($actionType, $from, $to)
    {
        return DB::table('logs')->where(['action_type' => $actionType])->whereBetween('time', [$from, $to])->get()->count();
    }
    #############################################################################################################################


    public static function TopActiveUsers($from, $to)
    {
      return  $data  =  DB::table('logs')
            ->join('users', 'users.id', '=', 'logs.user_id')
            ->where(['action_type' => 1, 'user_type' => 2])
            ->whereBetween('time', [$from, $to])
            ->select('users.id', 'users.name', 'users.image')
            ->take(10)
            ->groupBy('users.id')
            ->get();
        return $data;
    }

    #############################################################################################################################

    public static function TopCountries($from,$to)
    {

        $data  =  DB::table('logs')
            ->where(['action_type' => 1])
            ->whereBetween('time', [$from, $to])
            ->select('country', DB::raw('count(*) as total'))
            ->groupBy('country')
            ->get();
        return $data;
    }
    #############################################################################################################################

}
