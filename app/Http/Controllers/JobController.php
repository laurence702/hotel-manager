<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jobs\SendWelcomeEmail;
use Carbon\Carbon;

class JobController extends Controller
{
    public function processQueue()
    {
        $emailJob = new SendWelcomeEmail();
        dispatch($emailJob)->delay(Carbon::now()->addMinutes(1));;
        return redirect()->route('admin.bookings.index');
    }
}
