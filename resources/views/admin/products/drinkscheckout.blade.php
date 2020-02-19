@inject('request', 'Illuminate\Http\Request')
@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('quickadmin.customers.title')</h3>
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
       
        @foreach($products as $product)
        <tbody>
            <tr id="row1">
                <td data-th="Product">
                    <div class="row">
                        <div class="col-sm-2 hidden-xs">
                        <i style="color:#e64980" class="fa fa-wine-bottle fa-4x"></i>
                        </div>
                        <div class="col-sm-10">
                            <span><i class="fa fa-wine"></i><input style="text-align:center; border-radius:20px; margin-top:15px; font-size:18px; background-color:#239dcf;" type="text" name="" class="_drink" id="" value="{{$product->name}}" disabled><span>
                            <p style="font-size:12px"><span style="color:lemongreen;">description:</span> {{ $product->description }}</p>
                            <button class="refresher btn btn-info btn-sm"><i class="fa fa-refresh"></i></button>
                            <button class="delete-product btn btn-danger btn-sm"><i class="fa fa-trash-o"></i></button>
                        </div>
                    </div>
                </td>
                <td data-th="Price">
                <input type="text" id="ourPrice" disabled value="{{ $product->price}}" class="product-price form-control" />
                </td>
                <td data-th="Quantity">
                    <input id="ourQty" type="number" min="1" class="form-control text-center myQty product-qty" value="0">
                </td>
                <td id="subTotal" data-th="Subtotal" class="text-center">
                    <input type="number" id="productPrice" disabled value="0" class="form-control totalprice product-total-price" />
                    <!-- <span class="totalprice" id="productPrice">150.00</span> -->
                </td>
                <td class="actions" data-th="">
                   								
                </td>
            </tr>
            
        </tbody>
       @endforeach
        <tfoot>
            <tr class="visible-xs">
                <td class="text-center"><strong></strong></td>
            </tr>
            <tr>
                <td><a href="javascript:void(0);" id="finalCheckout" class="btn btn-warning"><i class="fa fa-angle-left"></i> Checkout</a></td>
                <td colspan="2" class="hidden-xs"></td>
                <td class="hidden-xs text-center" ><strong id="grandresult">Total #</strong></td>
            </tr>
        </tfoot>
	</table>

</div>
 
    </div>
        </div>
@stop
        

@section('javascript') 


    <script>
        $( document).ready (function (){
           
            $(".myQty").on('change', function (){
                
                let qtyVal=$(this).val();
                var $row=$(this).closest('tr');
                let productPrice=$row.find('#ourPrice').val();
                let Finalresult=qtyVal*productPrice;
                $row.find('#productPrice').val(Finalresult);

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
                   
                    e.preventDefault();

                    let order = [];

                    $("tbody tr").each(function(){
                        order.push({
                            drink_name: $(this).find('._drink').val(),
                            unit_price: $(this).find('#ourPrice').val(),
                            price: $(this).find('.product-price').val(),
                            qty: $(this).find('.product-qty').val(),
                            total: $(this).find('.product-total-price').val(),
                        })
                    });
                    console.log(order)
                    let csrfToken = @json(csrf_token());

                    $.ajax({
                        //Checkout
                        url: '/api/v1/drinkSaleInvoice',
                        headers: {'X-CSRF-TOKEN' : csrfToken},
                        type: 'POST',
                        data: {order:order},
                        datatype: 'json',
                        success: function(e){
                            console.log(e)
                        
                            swal ( "Success" ,  "Sold!" ,  "success" )
                            setTimeout(() => {
                                window.location.replace("/admin/printDrinkInvoice");
                            }, 2000);
                            
                        },   
                        error : function(e){
                            swal ( "Oops" ,  "Failed!!" ,  "error" )
                            setTimeout(() => {
                                location.reload();
                            }, 2000);
                           
                        }       
                   });

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