@inject('request', 'Illuminate\Http\Request')
@extends('layouts.app')

@section('content')
    <div class="panel-body">   
        <div class="col-md-4 col-xs-4"  style="background-color:#b5dfa3"> 
            <h3><i class="fa fa-money"></i> Today: ₦{{number_format($salesToday)}}</h3>
        </div> 
    </div> <br>
    <div class="row input-daterange">
        <div class="col-md-4">
            <input type="date" name="from_date" id="from_date" class="form-control" placeholder="From Date"/>
        </div>
        <div class="col-md-4">
            <input type="date" name="to_date" id="to_date" class="form-control" placeholder="To Date"/>
        </div>
        <div class="col-md-4">
            <button type="button" name="filter" id="filter" class="btn btn-primary">Filter</button>
            <button type="button" name="refresh" id="refresh" class="btn btn-default">Refresh</button>
        </div>
    </div>
       
        <div class="panel-body table-responsive">
            <table class="table table-bordered table-striped {{ count($sales) > 0 ? 'datatable' : '' }} @can('room_delete') @if ( request('show_deleted') != 1 ) dt-select @endif @endcan">
                <thead style="background-color:#2e6ae2">
                    <tr>
                        @can('room_delete')
                            @if ( request('show_deleted') != 1 )<th style="text-align:center;"><input type="checkbox" id="select-all" /></th>@endif
                        @endcan

                        <th>@lang('Product')</th>
                        <th>@lang('Quantity')</th>
                        <th>@lang('Unit Price')(#)</th>
                        <th>@lang('Value')</th>
                        <th>Sold At</th>
                        <th>Invoice Number</th>
                        <th>Sold By</th>
                    
                    </tr>
                </thead>
                
                <tbody>
                    @if (count($sales) > 0)
                        @foreach ($sales as $sale)
                            <tr data-entry-id="{{ $sale->id }}">
                                @can('room_delete')
                                    @if ( request('show_deleted') != 1 )<td></td>@endif
                                @endcan

                                <td field-key='product'>{{ $sale->product }}</td>
                                <td field-key='floor'>{{ $sale->quantity }}</td>
                                <td field-key='price'>{{ number_format($sale->unit_price)}}</td>
                                <td field-key='description'>{!! $sale->value !!}</td>    
                                <td field-key='sell_time'>{{ \Carbon\Carbon::parse($sale->created_at)->format('d-M   h:i') }}</td>                            
                                <td field-key='invoice_number'>{{ $sale->invoice_number}}</td>
                                <td>{{ $sale->soldBy}}</td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="8">@lang('quickadmin.qa_no_entries_in_table')</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    
@stop

@section('javascript') 
<script>
    $(document).ready(() => {
        $('#filter').click(()=>{
            timeFrom = $('#time_from').val()
            timeTo = $('#time_to').val()

            alert('today is '+ timeFrom)
        })
    })
</script>
   
@endsection