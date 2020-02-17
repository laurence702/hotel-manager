@inject('request', 'Illuminate\Http\Request')
@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('quickadmin.bookings.title')</h3>
    @can('booking_create')
    <p>
        <a href="{{ route('admin.bookings.create') }}" class="btn btn-success">@lang('quickadmin.qa_add_new')</a>
        
    </p>
    @endcan

    @can('booking_delete')
    <p>
        <ul class="list-inline">
            <li><a href="{{ route('admin.bookings.index') }}" style="{{ request('show_deleted') == 1 ? '' : 'font-weight: 700' }}">@lang('quickadmin.qa_all')</a></li> |
            <li><a href="{{ route('admin.bookings.index') }}?show_deleted=1" style="{{ request('show_deleted') == 1 ? 'font-weight: 700' : '' }}">@lang('quickadmin.qa_trash')</a></li>
        </ul>
    </p>
    @endcan


    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.qa_list')
        </div>

        <div class="panel-body table-responsive">
 
            <table id="table" class="table table-bordered table-striped {{ count($products) > 0 ? 'datatableemeka' : '' }} @can('products_delete') @if ( request('show_deleted') != 1 ) dt-select @endif @endcan">
                <thead>
                    <tr>
                        @can('booking_delete')
                            @if ( request('show_deleted') != 1 )<th style="text-align:center;"><input type="checkbox" id="select-all" /></th>@endif
                        @endcan

                        <th>Product Name</th>
                        <th>Price</th>
                        <th>Description</th>
                        
                        @if( request('show_deleted') == 1 )
                        <th>&nbsp;</th>
                        @else
                        @endif
                    </tr>
                </thead>
                
                <tbody>
                    @foreach($products as $product)
                    <tr data-entry-id="{{$product->id}}">
                        @if ( request('show_deleted') != 1 )
                        <th style="text-align:center;"><input type="checkbox" id="select-all" /></th>@endif
                        <td class="some">{{$product->name}}</td>
                        <td>{{$product->price}}</td>
                        <td>{{$product->description}}</td>
                    </tr>
                    @endforeach
                  
                </tbody>
            </table> <button id="checkout" class="btn btn-success btn-xs">Sell selected</button>
        </div>
    </div>
@stop

@section('javascript') 
    <script>
       
        var table = $('#table').DataTable({
                paging: true,
                destroy:true,
                searching: true,
                info: true,
                columnDefs: [{
 
                    targets: 0,
                    searchable:false,
                    orderable:false,
                    render: function (data, type, full, meta){
                    
                        return '<input class="product-checkbox checkbox" ' +
                            'type="checkbox" name="id[]" value="'+data.id+'">';
                    }
                }],
                select: {
                    style: 'single'
                },
                order: [[ 1, 'asc' ]],
                dom: "Bfrtip",
                buttons: ["colvis"],
                initComplete: (settings, json) => {
                     $('#checkout').click(function(){
                       
                       let selected = [];
                       
                        $('#table tr input:checked').each(function () {
                            let product_id = $(this).closest('tr').data('entry-id');

                            selected.push(product_id);
                         });
                        
                         
                         let csrfToken = @json(csrf_token());
                        
                        axios({
                            method: 'post',
                            url: '/api/drinkSaleInvoice',
                            data: selected                        
                        })
                        .then(function (response) {
                            window.location('http://thrivemax.test/admin/checkout')
                        })
                        .catch(function (error) {
                            console.log(error);
                        });
                      

                    //     $.ajax({
                    //     url: 'http://thrivemax.test/admin/sellDrinks',
                    //     headers: {'X-CSRF-TOKEN' : csrfToken},
                    //     type: 'POST',
                    //     data: {order:selected},
                    //     datatype: 'json',
                    //     success: function(e){
                    //         //console.log(e)  
                    //         window.location.replace('http://thrivemax.test/admin/sellDrinks')
                    //     }          
                    // });
                         
                     })
                    
                }
            });

    </script>
@endsection