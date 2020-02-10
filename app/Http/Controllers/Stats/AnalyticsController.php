<?php

namespace App\Http\Controllers\Stats;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Booking;
use App\Customer;
use Carbon\Carbon;

class AnalyticsController extends Controller
{
    
    public function getStats(){

        $todayBookingStats = Booking::whereDate('created_at',Carbon::today()->toDateString())->get();
        $yesterdayBookingStats = Booking::whereDate('created_at',Carbon::yesterday()->toDateString())->get();

        return view('home');
    }
}
