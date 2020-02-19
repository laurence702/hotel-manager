@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-10">
            <div class="panel panel-primary">
                <div class="panel-heading">Welcome {{ $user->name}}</div>
                    <div class="panel-body">    
                    @can('see_earnings')               
                        <div class="col-md-4"  style="background-color:#b5dfa3"> 
                            <h3><i class="fa fa-money"></i> ₦{{ number_format($todayBookingStats->sum('amount'))}}</h3>
                            Todays Earnings
                        </div> 
                        <div class="col-md-4 bg-info"> 
                            
                        </div>
                        <div class="col-md-4" style="background-color:#ff5252!important"> 
                            <h3><i class="fa fa-users"></i> {{ $todayBookingStats->count() }}</h3>
                             Today
                        </div>                    
                    </div>

                    <div class="panel-body">
                    <div class="col-md-4" style="background-color:#b5dfa3"> 
                        
                            <h3><i class="fa fa-money"></i> ₦{{ number_format($yesterdayBookingStats->sum('amount')) }}</h3>
                            Yesterdays
                        </div>
                        <div class="col-md-4 bg-info"> 
                           
                        </div>
                        <div class="col-md-4" style="background-color:#ff5252!important"> 
                            <h3><i class="fa fa-users"></i>{{ $yesterdayBookingStats->count() }}</h3>
                             Yesterday
                        </div>
                    </div>
                @endcan
            </div>
        </div>
    </div>
@endsection
