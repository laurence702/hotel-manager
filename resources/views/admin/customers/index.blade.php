@inject('request', 'Illuminate\Http\Request')
@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('quickadmin.customers.title')</h3>
    @can('customer_create')
    <p>
        <a href="{{ route('admin.customers.create') }}"><i class="fa fa-plus-square"></i> Add Customer</a>
        
    </p>
    @endcan

    @can('customer_delete')
    <p>
        <ul class="list-inline">
            <li><a href="{{ route('admin.customers.index') }}" style="{{ request('show_deleted') == 1 ? '' : 'font-weight: 700' }}"><i class="fa fa-users fa-2x"></i></a></li> 
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <li><a href="{{ route('admin.customers.index') }}?show_deleted=1" style="{{ request('show_deleted') == 1 ? 'font-weight: 700' : '' }}"><i class="fa fa-trash fa-2x" style="color:#d9534f"></i></a></i>
        </ul>
        <ul class="list-inline">
            <li>Customers</li> |
            <li>Trash</li>
        </ul>
    </p>
    @endcan


        <div class="panel-body table-responsive">
            <table class="table table-bordered table-striped {{ count($customers) > 0 ? 'datatable' : '' }} @can('customer_delete') @if ( request('show_deleted') != 1 ) dt-select @endif @endcan">
                <thead>
                    <tr class="bg-primary" style="background-color:#1674c5b3 !important;"> 
                        @can('customer_delete')
                            @if ( request('show_deleted') != 1 )<th style="text-align:center;"><input type="checkbox" id="select-all" /></th>@endif
                        @endcan

                        <th>@lang('quickadmin.customers.fields.first-name')</th>
                        <th>@lang('quickadmin.customers.fields.last-name')</th>
                        <th>@lang('quickadmin.customers.fields.address')</th>
                        <th>@lang('quickadmin.customers.fields.phone')</th>
                        <th>@lang('quickadmin.customers.fields.email')</th>
                        <th>@lang('quickadmin.customers.fields.country')</th>
                        @if( request('show_deleted') == 1 )
                        <th>&nbsp;</th>
                        @else
                        <th>&nbsp;</th>
                        @endif
                    </tr>
                </thead>
                
                <tbody>
                    @if (count($customers) > 0)
                        @foreach ($customers as $customer)
                            <tr data-entry-id="{{ $customer->id }}">
                                @can('customer_delete')
                                    @if ( request('show_deleted') != 1 )<td></td>@endif
                                @endcan

                                <td field-key='first_name'>{{ $customer->first_name }}</td>
                                <td field-key='last_name'>{{ $customer->last_name }}</td>
                                <td field-key='address'>{{ $customer->address }}</td>
                                <td field-key='phone'>{{ $customer->phone }}</td>
                                <td field-key='email'>{{ $customer->email }}</td>
                                <td field-key='country'>{{ $customer->country->title or '' }}</td>
                                @if( request('show_deleted') == 1 )
                                <td>
                                    @can('customer_delete')
                                                                        {!! Form::open(array(
                                        'style' => 'display: inline-block;',
                                        'method' => 'POST',
                                        'onsubmit' => "return confirm('".trans("quickadmin.qa_are_you_sure")."');",
                                        'route' => ['admin.customers.restore', $customer->id])) !!}
                                    {!! Form::submit(trans('quickadmin.qa_restore'), array('class' => 'btn btn-xs btn-success')) !!}
                                    {!! Form::close() !!}
                                @endcan
                                    @can('customer_thrash')
                                                                        {!! Form::open(array(
                                        'style' => 'display: inline-block;',
                                        'method' => 'DELETE',
                                        'onsubmit' => "return confirm('".trans("quickadmin.qa_are_you_sure")."');",
                                        'route' => ['admin.customers.perma_del', $customer->id])) !!}
                                    {!! Form::submit(trans('quickadmin.qa_permadel'), array('class' => 'btn btn-xs btn-danger')) !!}
                                    {!! Form::close() !!}
                                @endcan
                                </td>
                                @else
                                <td>

                                @can('customer_view')
                                <a href="{{ route('admin.customers.show',[$customer->id]) }}"><i style="color:#5cb85c" class="fa fa-eye fa-2x"></i></a>
                                @endcan
                                
                                @can('customer_edit')
                                <a href="{{ route('admin.customers.edit',[$customer->id]) }}"><i style="color:#428bca" class="fa fa-edit fa-2x"></i></a>
                                @endcan
                                @can('customer_delete')
                                {!! Form::open(array(
                                        'style' => 'display: inline-block;',
                                        'method' => 'DELETE',
                                        'onsubmit' => "return confirm('".trans("quickadmin.qa_are_you_sure")."');",
                                        'route' => ['admin.customers.destroy', $customer->id])) !!}
                                    {!! Form::submit(trans('quickadmin.qa_delete'), array('class' => 'btn btn-xs btn-danger')) !!}
                                    {!! Form::close() !!}
                                    @endcan
                                </td>
                                @endif
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="11">@lang('quickadmin.qa_no_entries_in_table')</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
   
@stop

@section('javascript') 
    <script>
        @can('customer_delete')
            @if ( request('show_deleted') != 1 ) window.route_mass_crud_entries_destroy = '{{ route('admin.customers.mass_destroy') }}'; @endif
        @endcan

    </script>
@endsection