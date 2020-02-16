@inject('request', 'Illuminate\Http\Request')
@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('quickadmin.drink_sales.title')</h3>
    @can('room_create')
    <p>
        <a href="{{ route('admin.products.create') }}" class="btn btn-success">@lang('quickadmin.qa_add_new')</a>
        
    </p>
    @endcan

    @can('room_delete')
    <p>
        <ul class="list-inline">
            <li><a href="{{ route('admin.products.index') }}" style="{{ request('show_deleted') == 1 ? '' : 'font-weight: 700' }}">@lang('quickadmin.qa_all')</a></li> |
            <li><a href="{{ route('admin.products.index') }}?show_deleted=1" style="{{ request('show_deleted') == 1 ? 'font-weight: 700' : '' }}">@lang('quickadmin.qa_trash')</a></li>
        </ul>
    </p>
    @endcan


    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.qa_list')
        </div>

        <table class="table">
            <thead class="thead-dark">
                <tr>
                <th scope="col"><input class='selectme' type="checkbox" ></th>
                <th scope="col">Product Name</th>
                <th scope="col">Price</th>
                <th scope="col">Description</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                <tr>
                    <th scope="row"><input type="checkbox" value="{{$product->id}}" name="sport"></th>
                    <td class="some">{{$product->name}}</td>
                    <td>{{$product->price}}</td>
                    <td>{{$product->description}}</td>
                </tr>
                @endforeach
            </tbody>
            </table>
            <br>
            <input type="button" id='sellall' class="btn btn-success" value="Sell all">
        </div>
    </div>
@stop

@section('javascript') 
    <script>
        $().ready(() => {
            $('#sellall').click(function(){
                let favorite = [];
                $('.selectme').each($(".selectme input[name='sport']:checked"), function(){
                    $('#sellall').click(function(){
                        favorite.push($(this).html());
                        console.log("My favourite sports are: " + favorite.join(", "));
                    })
                    
                });
            })
            
        })
    </script>
@endsection