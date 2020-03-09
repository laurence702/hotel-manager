@extends('layouts.app')

@section('content')
<h3 class="page-title">@lang('quickadmin.drink_sales.title')</h3>

{!! Form::model($product, ['method' => 'PUT', 'route' => ['admin.products.update', $product->id]]) !!}

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
        @lang('quickadmin.qa_edit')
    </div>

    <div class="panel-body">
        <div class="row">
            <div class="col-xs-12 form-group">
                {!! Form::label('name', trans('quickadmin.drink_sales.fields.product_name').'*', ['class' => 'control-label']) !!}
                {!! Form::text('name', old('name'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                <p class="help-block"></p>
                @if($errors->has('name'))
                <p class="help-block">
                    {{ $errors->first('name') }}
                </p>
                @endif
            </div>
        </div>


        <div class="row">
            <div class="col-xs-12 form-group">
                {!! Form::label('price', trans('quickadmin.drink_sales.fields.product_price').'*', ['class' => 'control-label']) !!}
                {!! Form::number('price', old('name'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                <p class="help-block"></p>
                @if($errors->has('name'))
                <p class="help-block">
                    {{ $errors->first('name') }}
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
                {!! Form::label('description', trans('quickadmin.rooms.fields.description').'*', ['class' => 'control-label']) !!}
                {!! Form::textarea('description', old('description'), ['class' => 'form-control ', 'placeholder' => '', 'required' => '','min' => '0']) !!}
                <p class="help-block"></p>
                @if($errors->has('description'))
                <p class="help-block">
                    {{ $errors->first('description') }}
                </p>
                @endif
            </div>
        </div>

    </div>
</div>

{!! Form::submit(trans('quickadmin.qa_update'), ['class' => 'btn btn-danger']) !!}
{!! Form::close() !!}
@stop