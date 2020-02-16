<?php

namespace App\Http\Controllers\Admin;

use App\Booking;
use App\Customer;
use App\Room;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreBookingsRequest;
use App\Http\Requests\Admin\UpdateBookingsRequest;
use Auth;
use Carbon\Carbon;
use Mail;

class BookingsController extends Controller
{

    /**
     * Display a listing of Booking.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!Gate::allows('booking_access')) {
            return abort(401);
        }


        if (request('show_deleted') == 1) {
            if (!Gate::allows('booking_delete')) {
                return abort(401);
            }
            $bookings = Booking::onlyTrashed()->get();
        } else {
            $bookings = Booking::all();
        }

        return view('admin.bookings.index', compact('bookings'));
    }

    /**
     * Show the form for creating new Booking.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!Gate::allows('booking_create')) {
            return abort(401);
        }
        
        $customers = Customer::get()->pluck('full_name', 'id')->prepend(trans('quickadmin.qa_please_select'), '');
        //$rooms = Room::get()->pluck('room_number', 'id', 'price')->prepend(trans('quickadmin.qa_please_select'), 'choose room')->toarray();  
       $rooms = Room::all(); 

        return view('admin.bookings.create', compact('customers', 'rooms'));
    }

    /**
     * Store a newly created Booking in storage.
     *
     * @param  \App\Http\Requests\StoreBookingsRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!Gate::allows('booking_create')) {
            return abort(401);
        }

        //$booking = Booking::create($request->all());

        $bookersName = \Auth::user()->name;
       
        $data = $request->all(); 
        $booking = new Booking();
        $booking->amount_paid = $request->amount_paid; //actual amount paid
        $amount = $request->ourprice;
        $booking->amount = $amount + ($amount * 0.05);  //amount due with %5 vat
        $booking->time_from = $request->time_from;     
        $booking->time_to = $request->time_to; 
        $booking->additional_information = $request->additional_information; 
        $booking->customer_id = $request->customer_id;
        $booking->room_id = $request->room_cat; 
        $booking->payment_method = 'CASH';
        $booking->booked_by = $bookersName;        
        $querySuccess = $booking->save();

        if( $booking->amount_paid < $booking->amount ){
            //get admin user which is the first user in db
            $admin = User::where('role_id','2')->first();
            
            $adminName = $admin['name'];
            $emailAddress =$admin['email'];
            $mailSent =Mail::send('mails.anomaly', $data,function($message) use ($emailAddress, $bookersName, $adminName){
                             
                $message->to($emailAddress, 'CEO ThriveMax')
                        ->subject('Possible Fraud');
                $message->from('bookings@thrivemaxhotel.com','ThriveMax App Threat detector');
            });
        }
        return redirect()->route('admin.bookings.index');
    }


    /**
     * Show the form for editing Booking.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (!Gate::allows('booking_edit')) {
            return abort(401);
        }

        $customers = Customer::get()->pluck('first_name', 'id')->prepend(trans('quickadmin.qa_please_select'), '');
        $rooms = Room::get()->pluck('room_number', 'id')->prepend(trans('quickadmin.qa_please_select'), '');

        $booking = Booking::findOrFail($id);

        return view('admin.bookings.edit', compact('booking', 'customers', 'rooms'));
    }

    /**
     * Update Booking in storage.
     *
     * @param  \App\Http\Requests\UpdateBookingsRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateBookingsRequest $request, $id)
    {
        if (!Gate::allows('booking_edit')) {
            return abort(401);
        }
        $booking = Booking::findOrFail($id);
        $booking->update($request->all());


        return redirect()->route('admin.bookings.index');
    }


    /**
     * Display Booking.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (!Gate::allows('booking_view')) {
            return abort(401);
        }
        $booking = Booking::findOrFail($id);
        $checkout = Carbon::parse($booking->time_to);
        $checkIn = Carbon::parse($booking->time_from);
        $nod = $checkIn->diffInDays($checkout);
        return view('admin.bookings.show', compact('booking','nod'));
    }


    /**
     * Remove Booking from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!Gate::allows('booking_delete')) {
            return abort(401);
        }
        $booking = Booking::findOrFail($id);
        $booking->delete();

        return redirect()->route('admin.bookings.index');
    }

    /**
     * Delete all selected Booking at once.
     *
     * @param Request $request
     */
    public function massDestroy(Request $request)
    {
        if (!Gate::allows('booking_delete')) {
            return abort(401);
        }
        if ($request->input('ids')) {
            $entries = Booking::whereIn('id', $request->input('ids'))->get();

            foreach ($entries as $entry) {
                $entry->delete();
            }
        }
    }


    /**
     * Restore Booking from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        if (!Gate::allows('booking_delete')) {
            return abort(401);
        }
        $booking = Booking::onlyTrashed()->findOrFail($id);
        $booking->restore();

        return redirect()->route('admin.bookings.index');
    }

    /**
     * Permanently delete Booking from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function perma_del($id)
    {
        if (!Gate::allows('booking_delete')) {
            return abort(401);
        }
        $booking = Booking::onlyTrashed()->findOrFail($id);
        $booking->forceDelete();

        return redirect()->route('admin.bookings.index');
    }
}
