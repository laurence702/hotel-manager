@extends('layouts.app')

@section('content')
<h3 class="page-title">Drink Sales</h3>
{!! Form::open(['method' => 'POST', 'route' => ['admin.products.store']]) !!}

<div class="panel panel-default">
    <div class="panel-heading">
        @lang('quickadmin.qa_create') drinks
    </div>

    <div class="panel-body">

        <div class="row">
            <div class="col-xs-12 form-group">
                {!! Form::label('name', trans('quickadmin.qa_product_name').'*', ['class' => 'control-label']) !!}
                {!! Form::text('name', old('name'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                <p class="help-block"></p>
                @if($errors->has('product_name'))
                <p class="help-block">
                    {{ $errors->first('product_name') }}
                </p>
                @endif
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12 form-group">
                {!! Form::label('description', trans('quickadmin.qa_product_description').'*', ['class' => 'control-label']) !!}
                {!! Form::text('description', old('description'), ['class' => 'form-control ', 'placeholder' => '', 'required' => '']) !!}
                <p class="help-block"></p>
                @if($errors->has('description'))
                <p class="help-block">
                    {{ $errors->first('description') }}
                </p>
                @endif
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12 form-group">
                {!! Form::label('Precio',trans('Stock Count').'*') !!}
                {!! Form::number('stock_count', old('stock_count'), ['class' => 'form-control ', 'placeholder' => '', 'required' => '','min' => '0']) !!}
                <p class="help-block"></p>
                @if($errors->has('stock_count'))
                <p class="help-block">
                    {{ $errors->first('stock_count') }}
                </p>
                @endif
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12 form-group">
                {!! Form::label('Precio',trans('quickadmin.qa_product_price').'*') !!}
                {!! Form::number('price', old('price'), ['class' => 'form-control ', 'placeholder' => '', 'required' => '','min' => '0']) !!}
                <p class="help-block"></p>
                @if($errors->has('price'))
                <p class="help-block">
                    {{ $errors->first('price') }}
                </p>
                @endif
            </div>
        </div>

    </div>
</div>

{!! Form::submit(trans('quickadmin.qa_save'), ['class' => 'btn btn-danger']) !!}
{!! Form::close() !!}
@stop

@section('javascript')
@parent
<script src="https://cdn.datatables.net/select/1.2.0/js/dataTables.select.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.20.1/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>
@stop