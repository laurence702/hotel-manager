<html>
 <head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{env('APP_NAME')}}</title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
  <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
  <link rel="stylesheet"
      href="//cdn.datatables.net/buttons/1.2.4/css/buttons.dataTables.min.css"/>
  <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>  
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" />
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker.css" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.js"></script>
 
    <script src="//cdn.datatables.net/1.10.9/js/jquery.dataTables.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
    <script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
    <script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.4/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.4/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.4/js/buttons.colVis.min.js"></script>
    <script src="https://cdn.datatables.net/select/1.2.0/js/dataTables.select.min.js"></script>
 </head>
 <body>
  <div class="container">    
     <br />
     <h3 align="center">Product Sales Report</h3>
     <br/><br/>
        <div class="row input-daterange">
            <div class="col-md-4">
                <input type="text" name="from_date" id="from_date" class="form-control" placeholder="From Date" readonly />
            </div>
            <div class="col-md-4">
                <input type="text" name="to_date" id="to_date" class="form-control" placeholder="To Date" readonly />
            </div>
            <div class="col-md-4">
                <button type="button" name="filter" id="filter" class="btn btn-primary">Filter</button>
                <button type="button" name="refresh" id="refresh" class="btn btn-default">Refresh</button>
            </div>
        </div>
            <br />
   <div class="table-responsive">
    <table class="table table-bordered table-striped" id="order_table">
           <thead style="background-color:coral;">
            <tr>
                <th>@lang('Product')</th>
                <th>@lang('Quantity')</th>
                <th>@lang('Unit Price')(#)</th>
                <th>@lang('Value')</th>
                <th>Sold By</th>
                <th>Invoice Number</th>                
                <th>Sold At</th>
            </tr>
           </thead>
       </table>
   </div>
  </div>
 </body>
</html>

<script>
$(document).ready(function(){
 $('.input-daterange').datepicker({
  todayBtn:'linked',
  format:'yyyy-mm-dd',
  autoclose:true
 });

 load_data();

 function load_data(from_date = '', to_date = '')
 {
  $('#order_table').DataTable({
    buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ],
   processing: true,
   serverSide: true,
   
   ajax: {
    data:{from_date:from_date, to_date:to_date}
   },
   columns: [
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
     name: 'created_at'
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