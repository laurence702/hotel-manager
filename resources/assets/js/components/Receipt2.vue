<template>
    <div>
        <div class="ticket" style="margin-left:10px">
        <img src="/imgs/main-logo.png"  width="100"/>
            <p class="centered"><b>THRIVEMAX HOTEL</b>
                <br>15 Odunlanmi Str,
                <br>Lagos Island &nbsp;
                09017331111
            </p>
            <div>
                <b>Cashier: </b>{{ soldBy}} <br>
                <b>Date:</b> {{ purchaseDate }} <br>
                <b>Invoice_number:</b> <br> {{ invoice_number }} 
            </div>
            
            <table>
                <thead>
                    <tr>
                        <th class="description">Qty</th>
                        <th>&nbsp;</th>
                        <th class="price">Product</th>
                        <th>&nbsp;</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="purchase in purchases" v-bind:key="purchase.id">
                        <td class="description">{{purchase.quantity}}</td>
                        <td>&nbsp;</td>
                        <td class="price">{{purchase.product}}</td>
                        <td>&nbsp;</td>
                        <td>{{purchase.value}}.00</td>
                    </tr>
                   
                </tbody>
            </table>
            <br>
            -----------------------------<br>
            <i>Subtotal</i> &emsp;&emsp;&emsp; ₦{{new Intl.NumberFormat().format(total)}}.00 <br>
            -----------------------------
            <p class="centered">Thanks for your business <br>
            <b>thrivemaxhotel.com</b></p> 
        </div>        
    </div>
</template>

<script>
//eslint-ignore
    export default {
        data(){
            return {
                purchases:[],
                total:'',
                vat: '',
                purchaseDate:'',
                invoice_number:'',
                soldBy:'',
                purchase: {
                    id:'',
                    price:'',
					quantity:'',
                    unit_price :'',
                    value:'',
                    invoice_number:'',
                    total: '',
                    purchaseDate:''
                }
            }
        },
          created() {
			this.fetchPurchaseDetails(); 
			
        },

        methods: {
            fetchPurchaseDetails() {
                fetch('/api/getlastorder')
                .then(res => res.json())
                .then(res => {                   
                    this.purchases = res.data;
					this.total = res.total;
					this.unit_price = res.unit_price;
                    this.taxedTotal = res.TotalwithTax;
                    this.soldBy = res.data[0].soldBy.split("Cashier: ")[1];
                    this.purchaseDate = res.data[0].created_at;
                    this.invoice_number = res.data[0]['invoice_number'];
                    console.log(res)                    
				})
				.then(
					// setTimeout(() => {
                    //     window.print();
                    // }, 2000)
                    window.print(),
                    window.onafterprint = function(event) {
                        window.location.href = '/'
                    }
				)
                
                .catch(err => console.log(err))
            }
        }

    }
</script>

<style>

</style>