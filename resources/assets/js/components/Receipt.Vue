<template>
       
  <div id="invoice-POS">
    
    <center id="top">
      <div class="logo"></div>
      <div class="info"> 
        <h2>THRIVEMAX HOTEL</h2>
      </div><!--End Info-->
    </center><!--End InvoiceTop-->
    
    <div id="mid">
      <div class="info">
        <p>                
            <b>Address</b> : 15 Odunlanmi Str,Lagos Island</br>
            <b>Email</b>   : info@thrivemaxhotel.com</br>
            <b>Phone</b>   : 09017331111, 09032222000</br>
        </p>
      </div>
    </div><!--End Invoice Mid-->
    
    <div id="bot">

					<div id="table">
						<table>
							<tr class="tabletitle">
								<td class="item"><h2>Item</h2></td>
								<td class="Hours"><h2>Qty</h2></td>
                                <td class="Hours"><h2>Value</h2></td>
								<td class="Rate"><h2>Sub Total</h2></td>
							</tr>

							<tr class="service" v-for="purchase in purchases" v-bind:key="purchase.id">
								<td class="tableitem"><p class="itemtext">{{purchase.product}}</p></td>
								<td class="tableitem"><p class="itemtext">{{purchase.quantity}}</p></td>
								<td class="tableitem"><p class="itemtext">100</p></td>
                                <td class="tableitem"><p class="itemtext">{{purchase.value}} </p></td>
							</tr>



							<tr class="tabletitle">
								<td></td>
								<td class="Rate"><h2>tax</h2></td>
								<td class="payment"><h2>#{{vat}}</h2></td>
                                <td class="payment"></td>
							</tr>

							<tr class="tabletitle">
								<td></td>
								<td class="Rate"><h2>Total</h2></td>
								<td class="payment"><h2>#{{total + vat}}</h2></td>
                             <td class="payment"></td>
							</tr>

						</table>
					</div><!--End Table-->

					<div id="legalcopy">
						 ---------------------
                     <p class="centered">Thanks for your business
                        <b>www.thrivemaxhotel.com</b></p>
                        ----------------------
					</div>

				</div><!--End InvoiceBot-->
  </div><!--End Invoice-->

</template>

<script>
    export default {
        data(){
            return {
                purchases:[],
                total:'',
                taxedTotal:'',
                vat: '',
                purchase: {
                    id:'',
                    price:'',
                    quantity:'',
                    value:'',
                    invoice_number:'',
                    total: ''
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
                    this.taxedTotal = res.TotalwithTax;
                    this.vat = res.taxAmount;
                    console.log(res)
				})
				.then(
					setTimeout(() => {
						window.print();
					}, 2000)
				)
                
                .catch(err => console.log(err))
            }
        }


    }
</script>

<style>
body{
	margin: 0%;
}
#invoice-POS {
	 box-shadow: 0 0 1in -0.25in rgba(0, 0, 0, 0.5);
	 padding: 2mm;
	 margin: 0 auto;
	 width: 44mm;
	 background: #fff;
}
 #invoice-POS ::selection {
	 background: #f31544;
	 color: #fff;
}
 #invoice-POS ::moz-selection {
	 background: #f31544;
	 color: #fff;
}
 #invoice-POS h1 {
	 font-size: 1.5em;
	 color: #222;
}
 #invoice-POS h2 {
	 font-size: 0.9em;
}
 #invoice-POS h3 {
	 font-size: 1.2em;
	 font-weight: 300;
	 line-height: 2em;
}
 #invoice-POS p {
	 font-size: 0.7em;
	 color: #666;
	 line-height: 1.2em;
}
 #invoice-POS #top, #invoice-POS #mid, #invoice-POS #bot {
	/* Targets all id with 'col-' */
	 border-bottom: 1px solid #eee;
}
 #invoice-POS #top {
	 min-height: 100px;
}
 #invoice-POS #mid {
	 min-height: 80px;
}
 #invoice-POS #bot {
	 min-height: 50px;
}
 #invoice-POS #top .logo {
	 height: 60px;
	 width: 60px;
	 background: url(http://michaeltruong.ca/images/logo1.png) no-repeat;
	 background-size: 60px 60px;
}
 #invoice-POS .clientlogo {
	 float: left;
	 height: 60px;
	 width: 60px;
	 background: url(http://michaeltruong.ca/images/client.jpg) no-repeat;
	 background-size: 60px 60px;
	 border-radius: 50px;
}
 #invoice-POS .info {
	 display: block;
	 margin-left: 0;
}
 #invoice-POS .title {
	 float: right;
}
 #invoice-POS .title p {
	 text-align: right;
}
 #invoice-POS table {
	 width: 100%;
	 border-collapse: collapse;
}
 #invoice-POS .tabletitle {
	 font-size: 0.5em;
	 background: #eee;
}
 #invoice-POS .service {
	 border-bottom: 1px solid #eee;
}
 #invoice-POS .item {
	 width: 24mm;
}
 #invoice-POS .itemtext {
	 font-size: 0.5em;
}
 #invoice-POS #legalcopy {
	 margin-top: 5mm;
}
 
</style>
