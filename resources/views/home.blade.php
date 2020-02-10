@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-10">
            <div class="panel panel-primary">
                <div class="panel-heading">Welcome {{ $user->name}}</div>
                    <div class="panel-body">    
                    @can('see_earnings')               
                        <div class="col-md-4 bg-success"> 
                            <h3>Todays Income</h3>
                            {{ $todayBookingStats->sum('amount')}}
                        </div> 
                        <div class="col-md-4 bg-info"> 
                            <h3>Owed by customers</h3>
                                        0
                        </div>
                        <div class="col-md-4 bg-danger"> 
                            <h3>Customers Today</h3>
                            {{ $todayBookingStats->count() }} 
                        </div>                    
                    </div>

                    <div class="panel-body">
                    <div class="col-md-4 bg-success"> 
                            <h3>Yesterdays Income</h3>
                            {{ $yesterdayBookingStats->sum('amount')}}
                        </div>
                        <div class="col-md-4 bg-info"> 
                            <h3>Owed (Yesterday)</h3>
                                0
                        </div>
                        <div class="col-md-4 bg-danger"> 
                            <h3>Customers(Yesterday)</h3>
                            {{ $yesterdayBookingStats->count() }} 
                        </div>
                    </div>
                @endcan
            </div>
        </div>
    </div>
@endsection
