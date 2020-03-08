@inject('request', 'Illuminate\Http\Request')
@extends('layouts.app')

@section('css')

@endsection

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
            <table id="order_table" class="table table-bordered table-striped {{ count($sales) > 0 ? 'datatableemeka' : '' }} @can('room_delete') @if ( request('show_deleted') != 1 ) dt-select @endif @endcan">
                <thead style="background-color:#2e6ae2">
                    <tr>
                        @can('room_delete')
                            @if ( request('show_deleted') != 1 )<th style="text-align:center;"><input type="checkbox" id="select-all" /></th>@endif
                        @endcan
                        <th>Product Id</th>
                        <th>@lang('Product')</th>
                        <th>@lang('Quantity')</th>
                        <th>@lang('Unit Price')(#)</th>
                        <th>@lang('Value')</th>
                        <th>Invoice Number</th>
                        <th>Sold By</th>
                        <th>Sold At</th>                    
                    </tr>
                </thead>
              
            </table>
        </div>
    
@stop

@section('javascript') 
  
<script>
$(document).ready(function(){
 
 load_data();

 function load_data(from_date = '', to_date = '')
 {
    var table = $('#order_table').DataTable({
   processing: true,
   paging: true,
   searching: true,
   serverSide: true,
   ajax: {
    url:'{{ route("admin.products.saleshistory") }}',
    data:{from_date:from_date, to_date:to_date}
   },
   columns: [
    {
     data:'',
     name:''    
    },
    {
     data:'productId',
     name:'productId'
    },
    {
     data:'product',
     name:'product'
    },
    {
     data:'quantity',
     name:'quantity'
    },
    {
     data:'unit_price',
     name:'unit_price'
    },
    {
     data:'value',
     name:'value'
    },
    {
     data:'soldBy',
     name:'soldBy'
    },
    {
     data:'invoice_number',
     name:'invoice_number'
    },
    {
     data:'created_at',
     name:'created_at'
    }
   ]
  });
 }

 $('#filter').click(function(){
  var from_date = $('#from_date').val();
  var to_date = $('#to_date').val();
  if(from_date != '' &&  to_date != '')
  {
   $('#order_table').DataTable().destroy();
   load_data(from_date, to_date);
  }
  else
  {
   alert('Both Date is required');
  }
 });

 $('#refresh').click(function(){
  $('#from_date').val('');
  $('#to_date').val('');
  $('#order_table').DataTable().destroy();
  load_data();
 });

});
</script>
   
@endsection