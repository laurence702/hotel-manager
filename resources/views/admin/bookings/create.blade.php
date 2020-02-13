@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('quickadmin.bookings.title')</h3>
    {!! Form::open(['method' => 'POST', 'route' => ['admin.bookings.store']]) !!}

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.qa_create')
        </div>

        <div class="panel-body">
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('customer_id', trans('quickadmin.bookings.fields.customer').' *', ['class' => 'control-label']) !!}
                    {!! Form::select('customer_id', $customers, old('customer_id'), ['class' => 'form-control select2']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('customer_id'))
                        <p class="help-block">
                            {{ $errors->first('customer_id') }}
                        </p>
                    @endif
                </div>
            </div>
            
            <div class="row">
                <div class="col-xs-12 form-group">
                    <label for="_room">Room</label>
                        <select name="room_cat" id="_room">
                        <option value='' selected hidden>select...</option>
                        @foreach($rooms as $room)
                            <option data-price="{{ $room->price }}" value="{{ $room->room_number }}">{{ $room->room_number}}</option>
                        @endforeach
                        </select> <br><br>   <b> Room Price: ₦<span id='roomprice'></span></b>
                    <p class="help-block"></p>
                    @if($errors->has('room_id'))
                        <p class="help-block">
                            {{ $errors->first('room_id') }}
                        </p>
                    @endif
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('time_from', trans('quickadmin.bookings.fields.time-from').'*', ['class' => 'control-label ']) !!}
                    {!! Form::text('time_from', old('time_from'), ['class' => 'form-control datetimepicker time_from', 'placeholder' => '', 'required' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('time_from'))
                        <p class="help-block">
                            {{ $errors->first('time_from') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('time_to', trans('quickadmin.bookings.fields.time-to').'*', ['class' => 'control-label']) !!}
                    {!! Form::text('time_to', old('time_to'), ['class' => 'form-control datetimepicker', 'placeholder' => '', 'required' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('time_to'))
                        <p class="help-block">
                            {{ $errors->first('time_to') }}
                        </p>
                    @endif
                </div>
            </div>

            <p id="test"><b>Days staying: 
                    <span id='ourdays'></span> </p></b><br>
            
            <div class="row">
                <div class="col-xs-12 form-group">
                    <label for="">Amount Due: ₦</label>
                    <span id='ourprice'></span>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('Precio',trans('Amount Paid').'*') !!}
                    {!! Form::number('amount', old('amount'), ['class' => 'form-control ', 'placeholder' => '', 'required' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('additional_information'))
                        <p class="help-block">
                            {{ $errors->first('additional_information') }}
                        </p>
                    @endif
                </div>
            </div>
           
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('additional_information', trans('quickadmin.bookings.fields.additional-information').'*', ['class' => 'control-label']) !!}
                    {!! Form::textarea('additional_information', old('additional_information'), ['class' => 'form-control ', 'placeholder' => 'if customer has unique request', 'required' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('additional_information'))
                        <p class="help-block">
                            {{ $errors->first('additional_information') }}
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
    <script>
       


        $(document ).ready(function() {   

            
            $('.datetimepicker').datetimepicker({
            format: "YYYY-MM-DD HH:mm"
            }); 



            $('#time_from').blur(function(){
                if($('#time_to').val()){
                    getTotalAmount();
                }
            });

            $('#time_to').blur(function(){
                if($('#time_from').val()){
                    getTotalAmount(); 
                }
            });

            $('#_room').change(function(){
                $('#roomprice').html($('#_room option:selected').data('price'));
                getTotalAmount();
            });
            

        });
     
        function getTotalAmount(){
            var timeto = $('#time_to').val()
            var timefrom = $('#time_from').val()
            var price = $('#roomprice').html() || 0
            var diffdays = daysdifference(timefrom, timeto)
            var amount = price * diffdays
            $('#ourdays').html(diffdays)
            $('#ourprice').html(amount)
        }

        function daysdifference(time_from, time_to){
                var startDay = new Date(time_from);
                var endDay = new Date(time_to);
            
                var millisBetween = startDay.getTime() - endDay.getTime();
                var days = millisBetween / (1000 * 3600 * 24);
            
                return Math.round(Math.abs(days));
        }
    </script>

@stop