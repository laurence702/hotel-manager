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
                        <div class="col-sm-2 hidden-xs"><img src="http://placehold.it/100x100" alt="..." class="img-responsive"/></div>
                        <div class="col-sm-10">
                            <h4 class="nomargin">{{ $product->name}}</h4>
                            <p>{{ $product->description }}</p>
                            <button class="refresher btn btn-info btn-sm"><i class="fa fa-refresh"></i></button>
                            <button class="delete-product btn btn-danger btn-sm"><i class="fa fa-trash-o"></i></button>
                        </div>
                    </div>
                </td>
                <td data-th="Price">
                <input type="text" id="ourPrice" disabled value="{{ $product->price}}" class="product-price form-control" />
                </td>
                <td data-th="Quantity">
                    <input id="ourQty" type="number" class="form-control text-center myQty product-qty" value="0">
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
                            price: $(this).find('.product-price').val(),
                            qty: $(this).find('.product-qty').val(),
                            total: $(this).find('.product-total-price').val(),
                        })
                    });

                    let csrfToken = @json(csrf_token());

                    $.ajax({
                        //Checkout
                        url: '/api/v1/drinkSaleInvoice',
                        headers: {'X-CSRF-TOKEN' : csrfToken},
                        type: 'POST',
                        data: {order:order},
                        datatype: 'json',
                        // success: function(e){
                        //     console.log(e)
                        
                        //     swal ( "Success" ,  "Sold!" ,  "success" )
                            
                        //     // window.location.replace("http://thrivemax.test/admin/sellDrinks");
                            
                        // },   
                        // error : function(e){
                        //     swal ( "Oops" ,  "Failed!!" ,  "error" )
                        //     location.reload();
                        // }       
                    });

                });

            
                $('.delete-product').click(function(){
                    console.log('product removed')
                    $(this).closest('tr').remove();
                })    

                $('.refresher').click(function(){
                    location.reload();
                })                       
            }); 
      
    </script>
@endsection