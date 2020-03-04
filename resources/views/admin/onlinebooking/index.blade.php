@inject('request', 'Illuminate\Http\Request')
@extends('layouts.app')

@section('content')
   <br>
    @can('booking_create')
    <p>
        <a href="{{ route('admin.bookings.create') }}"><i class="fa fa-plus-square"></i>Add Booking</a>
        
    </p>
    @endcan

    @can('booking_delete')
    <p>
        <ul class="list-inline">
            <li><a href="#" style="{{ request('show_deleted') == 1 ? '' : 'font-weight: 700' }}"><i class="fa fa-users fa-2x"></i></a></li> |
            
        </ul>
    </p>
    @endcan

    @if ($message = Session::get('success'))
        <div class="alert alert-success alert-block" style="background-color:green;">
            <button type="button" class="close" data-dismiss="alert">×</button>	
                <strong>{{ $message }}</strong>
        </div>
    @endif
    @if ($message = Session::get('error'))
        <div class="alert alert-danger alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button>	
                <strong>{{ $message }}</strong>
        </div>
    @endif

       
        <div class="panel-body table-responsive">
            <table class="table table-bordered table-striped {{ count($bookings) > 0 ? 'datatable' : '' }} @can('booking_delete') @if ( request('show_deleted') != 1 ) dt-select @endif @endcan">
                <thead>
                    <tr  style="background-color:#1674c5b3 !important;">
                        @can('booking_delete')
                            @if ( request('show_deleted') != 1 )<th style="text-align:center;"><input type="checkbox" id="select-all" /></th>@endif
                        @endcan

                        <th>@lang('quickadmin.bookings.fields.customer')</th>
                        <th>@lang('quickadmin.bookings.fields.room')</th>
                        <th>@lang('Arrival')</th>
                        <th>Phone</th>  
                        <th>@lang('Extra request')</th>                      
                        
                    </tr>
                </thead>
                
                <tbody>
                    @if (count($bookings) > 0)
                        @foreach ($bookings as $booking)
                            <tr data-entry-id="{{ $booking->id }}">
                                @can('booking_delete')
                                    @if ( request('show_deleted') != 1 )<td></td>@endif
                                @endcan

                                <td field-key='guest'>{{ $booking->guest->firstname or '' }} <br>
                                    
                                </td>
                                <td field-key='room'>{{ $booking->room_type or '' }}</td>
                                <td field-key='time_from'>{{ Carbon\Carbon::parse($booking->time_from)->format('M - d - Y h:i') }}</td>
                                <td field-key='phone'>{{$booking->guest->phone}}</td>                                
                                @if( request('show_deleted') == 1 )
                                <td>
                                
                                    @can('booking_delete')
                                                                        {!! Form::open(array(
                                        'style' => 'display: inline-block;',
                                        'method' => 'DELETE',
                                        'onsubmit' => "return confirm('".trans("quickadmin.qa_are_you_sure")."');",
                                        'route' => ['admin.bookings.perma_del', $booking->id])) !!}
                                    {!! Form::submit(trans('quickadmin.qa_permadel'), array('class' => 'btn btn-xs btn-danger')) !!}
                                    {!! Form::close() !!}
                                @endcan
                                </td>
                                @else
                                <td> {{$booking->extra_request}} </td>
                                @endif
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="10">@lang('quickadmin.qa_no_entries_in_table')</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    
@stop

@section('javascript') 
    <script>
       
    </script>
@endsection