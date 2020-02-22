<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        
        <title>ThriveMax Hotel</title>
    </head>
    <body>
        <div class="ticket">
        <img src="{{asset('/imgs/main-logo.png')}}" style="margin-left:40px" width="100"/>
            <p class="centered"><b>THRIVEMAX HOTEL</b>
                <br>15 Odunlanmi Str,
                <br>Lagos Island
                <br>09017331111
            </p>
            <table>
                <thead style="text-align:left">
                    <tr >
                        <th class="description">Description</th>
                        <th class="price">Amount(₦)</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="description">Hotel-Room({{$nod}}days)</td>
                        <td class="price">&nbsp;&nbsp;&nbsp;&nbsp;{{ $booking->amount_paid}}</td>
                    </tr>
                    <tr>
                        <td>%5 vat included</td>
                        <td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    </tr>
                    <tr>
                    <td> <br><strong>Net Amount</strong></td>
                    <td> <br>&nbsp;&nbsp;&nbsp;&nbsp;₦{{ number_format($booking->amount)  }}</td>
                    </tr>
                </tbody>
            </table>
            -------------------------------------- <br>
            <b>We offer free breakfast</b>
            <p class="centered">Have a wonderful stay
                <br><b>www.thrivemaxhotel.com</b></p>
        </div>
        <script>
            //delay print to ensure dom elements loads complete
            setTimeout(()=>{ 
                window.print();
                }, 2000);
        
        </script> 
    </body>
</html>