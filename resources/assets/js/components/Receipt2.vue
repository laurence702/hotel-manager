<template>
    <div class="ticket">
        <img src="/imgs/main-logo.png" style="margin-left:40px" width="100"/>
            <p class="centered"><b>THRIVEMAX HOTEL</b>
                <br>15 Odunlanmi Str,
                <br>Lagos Island
                <br>09017331111
            </p>
            <div>
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
                        <td>{{purchase.value}}</td>
                    </tr>
                   
                </tbody>
            </table>
            <br>
            ------------------------ <br>
            <i>Subtotal</i> &emsp;&emsp;&emsp; ₦{{total}} <br>
            ------------------------
            <p class="centered">Thanks for your business <br>
            <b>thrivemaxhotel.com</b></p>
            
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
                    const today = new Date();
                    const dd = String(today.getDate());
                    const mm = String(today.getMonth() + 1);
                    const yyyy= String(today.getFullYear());
                    this.purchases = res.data;
					this.total = res.total;
					this.unit_price = res.unit_price;
                    this.taxedTotal = res.TotalwithTax;
                    this.purchaseDate = dd+'/'+mm+'/'+yyyy;
                    this.invoice_number = res.data[0]['invoice_number'];
                    console.log(res)
				})
				.then(
					//window.print()
				)
                
                .catch(err => console.log(err))
            }
        }


    }
</script>

<style>

</style>