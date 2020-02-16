<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" href="style.css">
        <title>ThriveMax Hotel</title>
    </head>
    <body>
        <div class="ticket">
        <img src="{{asset('/imgs/main-logo.png')}}" style="margin-left:30px" width="80"/>
            <p class="centered"><b>THRIVEMAX HOTEL</b>
                <br>15 Odunlanmi Str,
                <br>Lagos Island
                <br>09017331111
            </p>
            <table>
                <thead>
                    <tr>
                        <th class="description">Description</th>
                        <th class="price">Amount(#)</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="description">Hotel-Room({{$nod}}days)</td>
                        <td class="price"> &nbsp;&nbsp;&nbsp;&nbsp;{{ $booking->amount_paid}}</td>
                    </tr>
                    <tr>
                        <td>vat %5</td>
                        <td>&nbsp;&nbsp;&nbsp;&nbsp; {{ $booking->amount * 0.05 }}</td>
                    </tr>
                    <tr>
                    <td><strong>Net Amount</strong></td>
                    <td>&nbsp;&nbsp;&nbsp;&nbsp;{{ $booking->amount + $booking->amount * 0.05  }}</td>
                    </tr>
                </tbody>
            </table>
            ----------------------------------
            <p class="centered">Have a wonderful stay
                <br><b>www.thrivemaxhotel.com</b></p>
        </div>
        <!-- <script>
            window.print();
        </script> -->
    </body>
</html>