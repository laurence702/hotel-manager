@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('quickadmin.drink_sales.title')</h3>

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.qa_view')
        </div>

        <div class="panel-body table-responsive">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-bordered table-striped">
                        <tr>
                            <th>@lang('quickadmin.drink_sales.fields.product_name')</th>
                            <td field-key='room_number'>{{ $product->name }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.drink_sales.fields.product_price')</th>
                            <td field-key='floor'>{{ $product->price }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.drink_sales.fields.description')</th>
                            <td field-key='description'>{!! $product->description !!}</td>
                        </tr>
                    </table>
                </div>
            </div><!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">

                <li role="presentation" class="active"><a href="#products" aria-controls="bookings" role="tab"
                                                          data-toggle="tab">Bookings</a></li>
            </ul>
          
            <p>&nbsp;</p>

            <a href="{{ route('admin.products.index') }}" class="btn btn-default">@lang('quickadmin.qa_back_to_list')</a>
        </div>
    </div>
@stop
