@inject('request', 'Illuminate\Http\Request')
@extends('layouts.app')

@section('content')
<h3 class="page-title">Drinks Section</h3>
@can('products_create')
<p>
    <a href="{{ route('admin.products.create') }}"><i class="fa fa-plus-square fa-2x"></i> Add Product</a>
    <br>
</p>
@endcan

@if(count($products ) < 1 ) <marquee attribute_name="attribute_value" ....more attributes>
    <span style="font-size:17px;color:red">Notification: We have no product in stock</span>
    </marquee>
    @else <div>
        <marquee attribute_name="attribute_value" ....more attributes>
            <span style="font-size:15px;color:red">Notification: {{$lowStock}} products low on stock , &emsp; {{$outOfStock}} products out of stock</span>
        </marquee>
    </div>
    @endif

    <div class="panel panel-default">
        @if ($message = Session::get('success'))
        <div class="alert alert-success alert-block" style="background-color:#ff4444;">
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
        <div class="panel-heading">
            @lang('quickadmin.qa_list')
        </div>

        <div class="panel-body table-responsive">

            <table id="table" class="table table-bordered table-striped {{ count($products) > 0 ? 'datatableemeka' : '' }} @can('products_delete') @if ( request('show_deleted') != 1 ) dt-select @endif @endcan">
                <thead style="background-color:#1674c5b3 !important;">
                    <tr>
                        @can('booking_delete')
                        @if ( request('show_deleted') != 1 )<th style="text-align:center;"><input type="checkbox" id="select-all" /></th>@endif
                        @endcan

                        <th>Product Name</th>
                        <th>Price(₦)</th>
                        <th>Stock count</th>
                        <th>Description</th>

                        @if( request('show_deleted') == 1 )
                        <th>&nbsp;</th>
                        @else
                        <th>&nbsp;</th>
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
                        @if($product->stock_count != 0)
                        <td>{{$product->stock_count}}</td>
                        @else<td style="color:red">Out of Stock</td>
                        @endif
                        <td>{{$product->description}}</td>
                        @if( request('show_deleted') == 1 )
                        <td>
                            @can('products_delete')
                            {!! Form::open(array(
                            'style' => 'display: inline-block;',
                            'method' => 'POST',
                            'onsubmit' => "return confirm('".trans("quickadmin.qa_are_you_sure")."');",
                            'route' => ['admin.products.restore', $product->id])) !!}
                            {!! Form::submit(trans('quickadmin.qa_restore'), array('class' => 'btn btn-xs btn-success')) !!}
                            {!! Form::close() !!}
                            @endcan
                            @can('products_thrash')
                            {!! Form::open(array(
                            'style' => 'display: inline-block;',
                            'method' => 'DELETE',
                            'onsubmit' => "return confirm('".trans("quickadmin.qa_are_you_sure")."');",
                            'route' => ['admin.products.perma_del', $product->id])) !!}
                            {!! Form::submit(trans('quickadmin.qa_permadel'), array('class' => 'btn btn-xs btn-danger')) !!}
                            {!! Form::close() !!}
                            @endcan
                        </td>
                        @else
                        <td>

                            @can('product_view')
                            <a href="{{ route('admin.products.show',[$product->id]) }}"><i style="color:#5cb85c" class="fa fa-eye fa-2x"></i></a>
                            @endcan
                            @can('products_edit')
                            <a href="{{ route('admin.products.edit',[$product->id]) }}"><i style="color:	#428bca" class="fa fa-edit fa-2x"></i></a>
                            @endcan
                            @can('products_delete')
                            {!! Form::open(array(
                            'style' => 'display: inline-block;',
                            'method' => 'DELETE',
                            'onsubmit' => "return confirm('".trans("quickadmin.qa_are_you_sure")."');",
                            'route' => ['admin.products.destroy', $product->id])) !!}
                            {!! Form::submit(trans('quickadmin.qa_delete'), array('class' => 'btn btn-xs btn-danger')) !!}
                            {!! Form::close() !!}
                            @endcan
                        </td>
                        @endif

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
            destroy: true,
            searching: true,
            info: true,
            columnDefs: [{

                targets: 0,
                searchable: false,
                orderable: false,
                render: function(data, type, full, meta) {

                    return '<input class="product-checkbox checkbox" ' +
                        'type="checkbox" name="id[]" value="' + data.id + '">';
                }
            }],
            select: {
                style: 'single'
            },
            order: [
                [1, 'asc']
            ],
            dom: "Bfrtip",
            buttons: ["colvis"],
            initComplete: (settings, json) => {
                $('#checkout').click(function() {

                    let selected = [];

                    $('#table tr input:checked').each(function() {
                        let product_id = $(this).closest('tr').data('entry-id');

                        selected.push(product_id);
                    });


                    let csrfToken = @json(csrf_token());

                    // console.log(selected)
                    axios({
                            method: 'post',
                            url: '/api/getselectedProduct',
                            data: selected,
                            headers: {
                                'X-CSRF-TOKEN': csrfToken
                            },
                        })
                        .then(function(res) {
                            let vm = res.data
                            console.log(vm);
                            window.localStorage.setItem("selectedItems", JSON.stringify(vm));
                            window.location = '/admin/checkout';
                        })
                        .catch(function(error) {
                            console.log(error);
                        });


                    //     $.ajax({
                    //     url: '/admin/sellDrinks',
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