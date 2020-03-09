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
        <li><a href="{{ route('admin.bookings.index') }}" style="{{ request('show_deleted') == 1 ? '' : 'font-weight: 700' }}"><i class="fa fa-users fa-2x"></i></a></li> |
        <li><a href="{{ route('admin.bookings.index') }}?show_deleted=1" style="{{ request('show_deleted') == 1 ? 'font-weight: 700' : '' }}"><i class="fa fa-trash fa-2x" style="color:#d9534f"></i></a></li>
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
            <tr style="background-color:#1674c5b3 !important;">
                @can('booking_delete')
                @if ( request('show_deleted') != 1 )<th style="text-align:center;"><input type="checkbox" id="select-all" /></th>@endif
                @endcan

                <th>@lang('quickadmin.bookings.fields.customer')</th>
                <th>@lang('quickadmin.bookings.fields.room')</th>
                <th>@lang('quickadmin.bookings.fields.time-from')</th>
                <th>@lang('quickadmin.bookings.fields.time-to')</th>
                <th>@lang('quickadmin.bookings.fields.amount_due')(₦)</th>
                <th>@lang('quickadmin.bookings.fields.discount')(₦)</th>
                <th>@lang('quickadmin.bookings.fields.additional-information')</th>
                <th>@lang('quickadmin.bookings.fields.booker_name')</th>
                @if( request('show_deleted') == 1 )
                <th>&nbsp;</th>
                @else
                <th>&nbsp;</th>
                @endif
            </tr>
        </thead>

        <tbody>
            @if (count($bookings) > 0)
            @foreach ($bookings as $booking)
            <tr data-entry-id="{{ $booking->id }}">
                @can('booking_delete')
                @if ( request('show_deleted') != 1 )<td></td>@endif
                @endcan

                <td field-key='customer'>{{ $booking->customer->full_name or '' }} <br>
                    {!! Form::open(array(
                    'style' => 'display: inline-block;',
                    'method' => 'DELETE',
                    'onsubmit' => "return confirm('".trans("quickadmin.qa_are_you_sure")."');",
                    'route' => ['admin.bookings.destroy', $booking->id])) !!}
                    {!! Form::submit(trans('quickadmin.qa_checkout'), array('class' => 'btn btn-xs btn-danger')) !!}
                    {!! Form::close() !!}
                </td>
                <td field-key='room'>{{ $booking->room->room_number or '' }}</td>
                <td field-key='time_from'>{{ Carbon\Carbon::parse($booking->time_from)->format('M - d - Y h:i') }}</td>
                <td field-key='time_to'>{{ Carbon\Carbon::parse($booking->time_to)->format('M - d - Y') }} 12pm </td>
                <td field-key='amount'>{{ number_format($booking->amount) }}</td>
                <td field-key='amount'>{{ number_format($booking->discount_amount) }}</td>
                <td field-key='additional_information'>{!! $booking->additional_information !!}</td>
                <td field-key='booker_name'>{{ $booking->booked_by }}</td>
                @if( request('show_deleted') == 1 )
                <td>
                    @can('booking_delete')
                    {!! Form::open(array(
                    'style' => 'display: inline-block;',
                    'method' => 'POST',
                    'onsubmit' => "return confirm('".trans("quickadmin.qa_are_you_sure")."');",
                    'route' => ['admin.bookings.restore', $booking->id])) !!}
                    {!! Form::submit(trans('quickadmin.qa_restore'), array('class' => 'btn btn-xs btn-success')) !!}
                    {!! Form::close() !!}
                    @endcan
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
                <td>
                    @can('booking_view')
                    <a href="{{ route('admin.bookings.show',[$booking->id]) }}"><i style="color:#5cb85c" class="fa fa-print fa-2x"></i></a>
                    @endcan
                    @can('booking_edit')
                    <a href="{{ route('admin.bookings.edit',[$booking->id]) }}"><i style="color:#428bca" class="fa fa-edit fa-2x"></i></a>
                    @endcan
                    <!-- @can('booking_delete')
                                    {!! Form::open(array(
                                        'style' => 'display: inline-block;',
                                        'method' => 'DELETE',
                                        'onsubmit' => "return confirm('".trans("quickadmin.qa_are_you_sure")."');",
                                        'route' => ['admin.bookings.destroy', $booking->id])) !!}
                                    {!! Form::submit(trans('quickadmin.qa_delete'), array('class' => 'btn btn-xs btn-danger')) !!}
                                    {!! Form::close() !!}
                                    @endcan -->
                </td>
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
    @can('booking_delete')
    @if(request('show_deleted') != 1) window.route_mass_crud_entries_destroy = '{{ route('admin.bookings.mass_destroy') }}';
    @endif
    @endcan
</script>
@endsection