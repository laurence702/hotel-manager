<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Booking;
use Carbon\Carbon;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = \Auth::user();
        //print $user;
        $todayBookingStats = Booking::all();
        $yesterdayBookingStats = Booking::whereDate('created_at',Carbon::yesterday()->toDateString())->get();

       return view('home',compact('todayBookingStats','yesterdayBookingStats', 'user'));
    }
}
