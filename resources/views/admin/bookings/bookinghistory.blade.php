@inject('request', 'Illuminate\Http\Request')
@extends('layouts.app')

@section('css')

@endsection

@section('content')
<div class="panel-body">

</div>
<div class="row input-daterange">
    <div class="col-md-4">
        <input type="date" name="from_date" id="from_date" class="form-control" placeholder="From Date" />
    </div>
    <div class="col-md-4">
        <input type="date" name="to_date" id="to_date" class="form-control" placeholder="To Date" />
    </div>
    <div class="col-md-4">
        <button type="button" name="filter" id="filter" class="btn btn-primary">Filter</button>
        <button type="button" name="refresh" id="refresh" class="btn btn-default">Refresh</button>
    </div>
</div>

<div class="panel-body table-responsive">
    <table id="order_table" class="table table-bordered table-striped">
        <thead style="background-color:#2e6ae2">
            <tr>
                <th>@lang('Room Number')</th>
                <th>@lang('quickadmin.bookings.fields.customer')</th>
                <th>@lang('quickadmin.bookings.fields.amount_due')(₦)</th>
                <th>@lang('quickadmin.bookings.fields.discount')(₦)</th>
                <th>@lang('quickadmin.bookings.fields.time-from')</th>
                <th>@lang('quickadmin.bookings.fields.time-to')</th>
                <th>Payment method</th>
                <th>@lang('quickadmin.bookings.fields.booker_name')</th>
                <th>@lang('quickadmin.bookings.fields.additional-information')</th>
            </tr>
        </thead>

    </table>
</div>

@stop

@section('javascript')

<script>
    $(document).ready(function() {

        load_data();

        function load_data(from_date = '', to_date = '') {
            $('#order_table').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ],
                processing: true,
                serverSide: true,
                stateSave: true,
                paging: true,
                ajax: {
                    data: {
                        from_date: from_date,
                        to_date: to_date
                    },
                },
                columns: [{
                        data: 'room_id',
                        name: 'room_id'
                    },
                    {
                        data: 'customer_id',
                        name: 'customer_id'
                    },
                    {
                        data: 'amount',
                        name: 'amount'
                    },
                    {
                        data: 'discount_amount',
                        name: 'discount_amount'
                    },
                    {
                        data: 'time_from',
                        name: 'time_from'
                    },
                    {
                        data: 'time_to',
                        name: 'time_to'
                    },
                    {
                        data: 'payment_method',
                        name: 'payment_method'
                    },
                    {
                        data: 'booked_by',
                        name: 'booked_by'
                    },
                    {
                        data: 'additional_information',
                        name: 'additional_information'
                    }
                ]
            });
        }

        $('#filter').click(function() {
            var from_date = $('#from_date').val();
            var to_date = $('#to_date').val();
            if (from_date != '' && to_date != '') {
                $('#order_table').DataTable().destroy();
                load_data(from_date, to_date);
            } else {
                alert('Both Date is required');
            }
        });

        $('#refresh').click(function() {
            $('#from_date').val('');
            $('#to_date').val('');
            $('#order_table').DataTable().destroy();
            load_data();
        });

    });
</script>

@endsection