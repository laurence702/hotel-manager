@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('quickadmin.bookings.title')</h3>

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.qa_view')
        </div>

        <div class="panel-body table-responsive">
        <!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>A simple, clean, and responsive HTML invoice template</title>
    
    <style>
    .invoice-box {
        max-width: 800px;
        margin: auto;
        padding: 30px;
        border: 1px solid #eee;
        box-shadow: 0 0 10px rgba(0, 0, 0, .15);
        font-size: 16px;
        line-height: 24px;
        font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
        color: #555;
    }
    
    .invoice-box table {
        width: 100%;
        line-height: inherit;
        text-align: left;
    }
    
    .invoice-box table td {
        padding: 5px;
        vertical-align: top;
    }
    
    .invoice-box table tr td:nth-child(2) {
        text-align: right;
    }
    
    .invoice-box table tr.top table td {
        padding-bottom: 20px;
    }
    
    .invoice-box table tr.top table td.title {
        font-size: 45px;
        line-height: 45px;
        color: #333;
    }
    
    .invoice-box table tr.information table td {
        padding-bottom: 40px;
    }
    
    .invoice-box table tr.heading td {
        background: #eee;
        border-bottom: 1px solid #ddd;
        font-weight: bold;
    }
    
    .invoice-box table tr.details td {
        padding-bottom: 20px;
    }
    
    .invoice-box table tr.item td{
        border-bottom: 1px solid #eee;
    }
    
    .invoice-box table tr.item.last td {
        border-bottom: none;
    }
    
    .invoice-box table tr.total td:nth-child(2) {
        border-top: 2px solid #eee;
        font-weight: bold;
    }
    
    @media only screen and (max-width: 600px) {
        .invoice-box table tr.top table td {
            width: 100%;
            display: block;
            text-align: center;
        }
        
        .invoice-box table tr.information table td {
            width: 100%;
            display: block;
            text-align: center;
        }
    }
    
    /** RTL **/
    .rtl {
        direction: rtl;
        font-family: Tahoma, 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
    }
    
    .rtl table {
        text-align: right;
    }
    
    .rtl table tr td:nth-child(2) {
        text-align: left;
    }
    </style>
</head>

<body>
    <div class="invoice-box">
        <table cellpadding="0" cellspacing="0">
            <tr class="top">
                <td colspan="2">
                    <table>
                        <tr>
                            <td class="title">
                                <img src="{{asset('/imgs/main-logo.png')}}" width="80"/>
                            </td>
                            
                            <td>
                                Invoice #: {{ $booking->customer->id or '' }} <br>
                                Booking Date: {{ Carbon\Carbon::parse($booking->time_from)->format('D d-M-Y') }}<br>
                                Exit Date: {{ Carbon\Carbon::parse($booking->time_to)->format('D d-M-Y') }}

                                
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            
            <tr class="information">
                <td colspan="2">
                    <table>
                        <tr>
                            <td>
                                15 Odunlami St, <br>
                                Lagos Island, Lagos<br>
                                Nigeria <br>
                                09017331111
                            </td>
                            
                            <td>
                                {{ $booking->customer->first_name or '' }}<br>
                                {{ $booking->customer->email or '' }}
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            
            <tr class="heading">
                <td>
                    Payment Method
                </td>
                
                <td>
                    Cash #
                </td>
            </tr>
            
            <tr class="details">
                <td>
                {{ $booking->payment_method or '' }}
                </td>
                
                
            </tr>
            
            <tr class="heading">
                <td>
                    Item
                </td>
                
                <td>
                    Amount Paid
                </td>
            </tr>
            
            <tr class="item">
                
            </tr>
            
                        
            <tr class="item last">
                <td>
                    Hotel Room
                </td>
                
                <td>
                #{{ $booking->amount or '' }}
                </td>
            </tr>
            
        </table>
    </div>
</body>
</html>

            <p>&nbsp;</p>

            <a href="{{ route('admin.bookings.index') }}" class="btn btn-default">@lang('quickadmin.qa_back_to_list')</a> 
            &nbsp; &nbsp; &nbsp;&nbsp; 
            <a id="print" click="print_receipt()" class="btn btn-success">Print Invoice</a>
        </div>
        <script  src="https://code.jquery.com/jquery-3.4.1.js"
                        integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU="
                        crossorigin="anonymous"></script>
                    <script>
                        
                        $(document).ready(function(){
                            $( "#print" ).click(function() {
                                window.print('');
                            });
                            
                        });

                        
                    </script>
    </div>
@stop
