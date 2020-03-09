<?php

namespace App\Http\Controllers\Stats;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Booking;
use App\Customer;
use Carbon\Carbon;
use DB;

class AnalyticsController extends Controller
{

    public function getStats(Request $request)
    {
        $xto = new Carbon($request->to_date);
        $xfrom = new Carbon($request->from_date);

        $from = $xfrom;
        $to = $xto;

        $BookingStats = Booking::whereBetween('created_at', [$from, $to])->withTrashed()->sum('amount');
        $clients = Booking::whereBetween('created_at', [$from, $to])->withTrashed()->count();
        return $arrayName = array('clients' => $clients, 'cashFlow' => number_format($BookingStats));
    }

    public function getStatsToday(Request $request)
    {
        $todayCashReports = Booking::whereDate('created_at', \DB::raw('CURDATE()'))->withTrashed()->sum('amount');
        $clientToday = Booking::whereDate('created_at', \DB::raw('CURDATE()'))->withTrashed()->count();
        return $Arr = array('clients' => $clientToday, 'cashFlow' => number_format($todayCashReports));
    }
}
