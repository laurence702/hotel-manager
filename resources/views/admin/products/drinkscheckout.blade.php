@inject('request', 'Illuminate\Http\Request')
@extends('layouts.app')

@section('content')
    <h3 class="page-title">Checkout</h3>
    <div class="panel panel-default">
                <div class="panel-heading">
                    @lang('quickadmin.qa_list')
                </div>
                <div class="panel-body">
    <div class="container">
	    <table id="cart" class="table table-hover table-condensed">
        <thead>
            <tr>
                <th style="width:40%">Product</th>
                <th style="width:10%">Price</th>
                <th style="width:10%">Quantity</th>
                <th style="width:15%" class="text-center">Subtotal</th>
                <th style="width:30%"></th>
            </tr>
        </thead>
        <div id="prods" style="">
      
        </div>

        <tbody id="selectedView"></tbody>
        <tfoot>
            <tr class="visible-xs">
                <td class="text-center"><strong></strong></td>
            </tr>
            <tr>
                <td><a href="javascript:void(0);" id="finalCheckout" class="btn btn-warning"><i class="fa fa-angle-left"></i> Checkout</a></td>
                <td colspan="2" class="hidden-xs"></td>
                <td class="hidden-xs text-center" ><strong id="grandresult">Total #</strong></td>
                
                <div class="" id="soldBy">
                Cashier: {{ \Auth::user()->name}}
                </div>
            </tr>
        </tfoot>        
	</table>
    </div>
   
        </div>
    </div>
@stop
        

@section('javascript') 


    <script>
    const renderSelectedItems = selectedItems => {
        const mainSelectView = document.getElementById("selectedView");
        selectedItems.forEach(ele => {
            const tem = `
                        <tr id="row1">
                                <td data-th="Product">
                                    <div class="row">
                                        <div class="col-sm-2 hidden-xs">
                                        <i style="color:#e64980" class="fa fa-wine-bottle fa-4x"></i>
                                        </div>
                                        <div class="col-sm-10">
                                            <span><i class="fa fa-wine"></i>
                                            <input placeholder="${ele.name}" style="text-align:center; border-radius:20px; margin-top:15px; font-size:18px; background-color:#239dcf;" type="text" name="" class="_drink" id="" value="${ele.name}" disabled>
                                            <span>
                                            <p style="font-size:15px"><span style="color:coral;">stock left:  ${ele.stock_count}</span> </p> 
                                            <p style="font-size:12px"><span style="color:lemongreen;">description:  ${ele.description}</span> </p>                          
                                            <p style="font-size:12px">Product Code:<input placeholder="${ele.id}" value="${ele.id}" style="width:29px" class="prod_Id" disabled></p>
                                            <button class="refresher btn btn-info btn-sm"><i class="fa fa-refresh"></i></button>
                                            <button class="delete-product btn btn-danger btn-sm"><i class="fa fa-trash-o"></i></button>
                                        </div>
                                    </div>
                                </td>
                                <td data-th="Price">
                                <input type="text" id="ourPrice" disabled value="${ele.price}" class="product-price form-control" />
                                </td>
                                <td data-th="Quantity">
                                    <input id="ourQty" data-value="${ele.stock_count}" type="number" min="1" class="form-control text-center myQty product-qty">
                                </td>
                                <td id="subTotal" data-th="Subtotal" class="text-center">
                                    <input type="number" id="productPrice" disabled value="0" class="form-control totalprice product-total-price" />
                                    <!-- <span class="totalprice" id="productPrice"></span> -->
                                </td>
                                <td class="actions" data-th="">
                                                                
                                </td>
                            </tr>       
                        `;

                     mainSelectView.innerHTML += tem;
        });
    };  
        $( document).ready (function (){
            const selectedItems = JSON.parse(window.localStorage.getItem("selectedItems"));            
                let prods= selectedItems;
                renderSelectedItems(selectedItems);
                isValidSale = false;
            $(".myQty").on('change', function (){    
                let myStockCount = $(this).attr('data-value')
                let qtyVal=$(this).val();
                var $row=$(this).closest('tr');
                let productPrice=$row.find('#ourPrice').val();
                let Finalresult=qtyVal*productPrice;
                $row.find('#productPrice').val(Finalresult);
                //check if requested is more than stock count
                if(parseInt(qtyVal) == 0){                    
                    swal('Oops!', 'You have to buy at least 1','info')
                    setTimeout(() => {
                        location.reload();
                    }, 2500);
                }
                if (parseInt(qtyVal) > parseInt(myStockCount)) {
                    swal({
                        title:'Oops!', 
                        text:`max of ${myStockCount} can be bought now`,
                        icon:'info'
                    })                    
                    setTimeout(() => {
                            location.reload();
                        }, 2500);
                }

                var TotalValue=0;
                $("tr").each(function(){
                       let grand= $(this).find('.totalprice').val()
                    if (grand !=undefined) {
                        TotalValue += parseFloat(grand);                        
                        $('#grandresult').html("Total #" + TotalValue+" :00");
                    }                    
                    // TotalValue += parseFloat($(this).find('.totalprice').html());
                    });                    
            });

            $('#finalCheckout').click(function(e)
            {         
                isValidSale=true          
                e.preventDefault();
                let order = [];
                let soldBy= $('#soldBy').html();
                console.log(soldBy);
                $("tbody tr").each(function(){
                    order.push({
                        product_id: $(this).find('.prod_Id').val(),
                        drink_name: $(this).find('._drink').val(),
                        unit_price: $(this).find('#ourPrice').val(),
                        price: $(this).find('.product-price').val(),
                        qty: $(this).find('.product-qty').val(),
                        total: $(this).find('.product-total-price').val(),
                        soldBy: soldBy
                    })
                });
                console.log(order)
                if(isValidSale == true){
                    let csrfToken = @json(csrf_token());
                    $.ajax({
                        url: '/api/v1/drinkSaleInvoice',
                        headers: {'X-CSRF-TOKEN' : csrfToken},
                        type: 'POST',
                        data: {order:order},
                        datatype: 'json'                         
                    }).done((res)=>{                            
                            console.log(res)                            
                            swal ( "Success" ,  "Sold!" ,  "success" )
                            localStorage.clear();
                            setTimeout(() => {
                                window.location.replace("/admin/printDrinkInvoice");
                            }, 2000);
                            
                    }).fail((err)=>{
                            message = err.responseText;
                            swal ( "Oops" ,  "Order could not be completed" ,  "error" )
                            console.log(err)
                            setTimeout(() => {
                                location.reload();
                            }, 2000);
                    })
                }else{
                    console.log(isValidSale)
                    swal ( "Order cant be processed" ,  "Please check the order details" ,  "error" )
                    location.reload();
                }       
            });
            
                $('.delete-product').click(function(){
                    console.log('product removed')
                    $(this).closest('tr').remove();
                })    

                $('.refresher').click(function(){
                    $(this).closest('.myQty').reset();
                })                       
            }); 
      
    </script>
@endsection
