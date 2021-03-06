@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('quickadmin.customers.title')</h3>
    {!! Form::open(['method' => 'POST', 'id'=>'myForm', 'route' => ['admin.customers.store']]) !!}

    <div class="panel panel-default">
        <div class="panel-heading text-white" style="background-color:#2e6ae2">
            @lang('quickadmin.qa_create')
        </div>
        
        <div class="panel-body">
            <h2 id='result'></h2>
            * fields are required
            <div class="row">
                <div class="col-xs-6 form-group">
                    {!! Form::label('first_name', trans('quickadmin.customers.fields.first-name').'*', ['class' => 'control-label']) !!}
                    {!! Form::text('first_name', old('first_name'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('first_name'))
                        <p class="help-block">
                            {{ $errors->first('first_name') }}
                        </p>
                    @endif
                </div>
                <div class="col-xs-6 form-group">
                    {!! Form::label('last_name', trans('quickadmin.customers.fields.last-name').'*', ['class' => 'control-label']) !!}
                    {!! Form::text('last_name', old('last_name'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('last_name'))
                        <p class="help-block">
                            {{ $errors->first('last_name') }}
                        </p>
                    @endif
                </div>
            </div>
           
            <div class="row">
                <div class="col-xs-6 form-group">
                    {!! Form::label('address', trans('quickadmin.customers.fields.address').'*', ['class' => 'control-label']) !!}
                    {!! Form::text('address', old('address'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('address'))
                        <p class="help-block">
                            {{ $errors->first('address') }}
                        </p>
                    @endif
                </div>
                <div class="col-xs-6 form-group">
                    {!! Form::label('phone', trans('quickadmin.customers.fields.phone').'*', ['class' => 'control-label']) !!}
                    {!! Form::text('phone', old('phone'), ['class' => 'form-control', 'pattern'=>'^[0]\d{10}$','title' => 'Example: 08012345678', 'maxlength' => '12', 'placeholder' => 'enter phone number...']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('phone'))
                        <p class="help-block">
                            {{ $errors->first('phone') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
               
            </div>
            <div class="row">
                <div class="col-xs-6 form-group">
                    {!! Form::label('email', trans('quickadmin.customers.fields.email'), ['class' => 'control-label']) !!}
                    {!! Form::email('email', old('email'), ['class' => 'form-control','title' => 'Example: abc@gmail.com','placeholder' => 'enter email here...']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('email'))
                        <p class="help-block">
                            {{ $errors->first('email') }}
                        </p>
                    @endif
                </div>
                <div class="col-xs-6 form-group">
                    {!! Form::label('country_id', trans('quickadmin.customers.fields.country').'', ['class' => 'control-label']) !!}
                    {!! Form::select('country_id', $countries, old('country_id'), ['class' => 'form-control select2']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('country_id'))
                        <p class="help-block">
                            {{ $errors->first('country_id') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                
            </div>
            <div align="center" style="color:#2e6ae2;"><h3>Next of Kin info</h3></div>
            <hr style="border-top: 1px solid #2e6ae2;">
            
            <div class="row">
                <div class="col-xs-6 form-group">
                
                    {!! Form::label('nok_name', trans('Name').'*', ['class' => 'control-label']) !!}
                    {!! Form::text('nok_name', old('nok_name'), ['class' => 'form-control', 'placeholder' => 'next of kin name','minlength' => '5','maxlength' => '23']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('nok_name'))
                        <p class="help-block">
                            {{ $errors->first('nok_name') }}
                        </p>
                    @endif
                </div>
                <div class="col-xs-6 form-group">
                    {!! Form::label('nok_phone', trans('Next of Kin Number').'*', ['class' => 'control-label']) !!}
                    {!! Form::number('nok_phone', old('nok_phone'), ['class' => 'form-control', 'pattern'=>'^[0]\d{10}$','title' => 'Example: 08012345678', 'maxlength' => '12','placeholder' => 'next of kin phone']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('nok_phone'))
                        <p class="help-block">
                            {{ $errors->first('nok_phone') }}
                        </p>
                    @endif
                </div>
            </div>
            {!! Form::submit(trans('quickadmin.qa_save'), ['class' => 'btn btn-success btn-lg']) !!}
    {!! Form::close() !!}
        </div>
    </div>

    

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>


    <script>
        function validateEmail(email) {
        var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(email);
        }

        function validate() {
        var $result = $("#result");
        var email = $("#email").val();
        $result.text("");

        if (validateEmail(email)) {
            $result.text("Email validated");
            $result.css("color", "green");
        } else {
            $result.text(email + " is not valid :(");
            $result.css("color", "red");
        }
        return false;
        }

        $("#myForm").on("submit", function(e) {
           validate();
        });
    </script>
@stop

