<?php

namespace App\Http\Controllers\Stats;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Booking;
use App\Customer;
use Carbon\Carbon;

class AnalyticsController extends Controller
{

    public function getStats(Request $request)
    {   
        $xto= new Carbon($request->to_date);
        $xfrom = new Carbon($request->from_date);

        $from = $xfrom;
        $to = $xto;

        $BookingStats = Booking::whereBetween('created_at', [$from, $to])->withTrashed()->sum('amount');
        $clients= Booking::whereBetween('created_at', [$from, $to])->withTrashed()->count();
        return $arrayName = array('clients' => $clients , 'cashFlow'=> number_format($BookingStats));
    }
}
