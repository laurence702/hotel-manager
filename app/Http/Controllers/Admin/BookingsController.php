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
use App\Mail\DiscountgivenNotification;

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

        $bookersName = \Auth::user()->name;
        $validator = \Validator::make($request->all(), [
            'customer_id' => 'required',
            'time_from' => 'required|date_format:'.config('app.date_format').' H:i',
            'time_to' => 'required|date_format:'.config('app.date_format'). ' H:i',

        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);

        }else{
            $discountGiven = isset($request->discount_amount);
            $discountPrice = $request->discount_amount;
            $AmountDue = $request->ourprice;
    
            $booking = new Booking();        
            $booking->amount =  $discountGiven ? (int)($AmountDue - $discountPrice)  : (int)($request->ourprice);  //amount due with %5 vat
            $booking->discount_amount= $discountPrice;
            $booking->time_from = $request->time_from;     
            $booking->time_to = $request->time_to; 
            $booking->additional_information = $request->additional_information; 
            $booking->customer_id = $request->customer_id;
            $booking->room_id = $request->room_cat; 
            $booking->payment_method = 'CASH';
            $booking->booked_by = $bookersName;
            $querySuccess = $booking->save();
            $bookingId = $booking->id;
            if($discountGiven){                
                $admin = User::where('role_id','2')->first();
                
                $adminName = $admin['name'];
                $emailAddress =$admin['email'];
                Mail::to($emailAddress)->send(new DiscountgivenNotification); //this is whats shoots mail to boss is theres discount
            }
            if($querySuccess){
              //redirect to print receipt page
              $booking = Booking::findOrFail($bookingId);
              return redirect()->route('admin.bookings.show',compact('booking'));
            }else{
                return redirect()->back()->with('errors',$errors);
            }
        }
     
        
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
