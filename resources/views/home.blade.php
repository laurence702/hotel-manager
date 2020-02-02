@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-10">
            <div class="panel panel-default">
                <div class="panel-heading">@lang('quickadmin.qa_dashboard')</div>

                <div class="panel-body">
                    <div class="col-md-4"> 
                        <h3>Bookings Today</h3>
                        <br>45
                    </div>
                    <div class="col-md-4"> 
                        <h3>Funds Received</h3>
                        <br>25
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
