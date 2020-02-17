 <div class="ticket">
        <img src="" style="margin-left:30px" width="80"/>
            <p class="centered"><b>THRIVEMAX HOTEL</b>
                <br>15 Odunlanmi Str,
                <br>Lagos Island
                <br>09017331111
            </p>
            <table>
                <thead>
                    <tr>
                        <th class="description">Item</th>
                        <th class="description">Qty</th>
                        <th class="description">Price</th>
                        <th class="price">Value(#)</th>
                    </tr>
                </thead>
                <tbody v-for="purchase in purchases" v-bind:key="purchase.id">
                    <tr>
                        <td class="">{{purchase.product}}</td>
                        <td class="">{{purchase.quantity}}</td>
                        <td class="">{{purchase.price}}</td>
                        <td class="price">{{purchase.value}}</td>
                    </tr>
                </tbody>
            </table>
            ----------------------------------
            <p class="centered">Have a wonderful stay
                <br><b>www.thrivemaxhotel.com</b></p>
        </div>