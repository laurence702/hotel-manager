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
                <th style="width:50%">Product</th>
                <th style="width:10%">Price</th>
                <th style="width:8%">Quantity</th>
                <th style="width:22%" class="text-center">Subtotal</th>
                <th style="width:10%"></th>
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
                        </div>
                    </div>
                </td>
                <td data-th="Price">
                <input type="text" id="ourPrice" disabled value="{{ $product->price}}" class="form-control" />
                </td>
                <td data-th="Quantity">
                    <input id="ourQty" class="myQty" type="number" class="form-control text-center" value="0">
                </td>
                <td id="subTotal" data-th="Subtotal" class="text-center">
                    <input type="number" id="productPrice" class="totalprice" disabled value="0" class="form-control" />
                    <!-- <span class="totalprice" id="productPrice">150.00</span> -->
                </td>
                <td class="actions" data-th="">
                    <button id="refresher" class="btn btn-info btn-sm"><i class="fa fa-refresh"></i></button>
                    <button class="btn btn-danger btn-sm"><i class="fa fa-trash-o"></i></button>								
                </td>
            </tr>
            
        </tbody>
       @endforeach
        <tfoot>
            <tr class="visible-xs">
                <td class="text-center" ><strong>Total 1.99</strong></td>
            </tr>
            <tr>
                <td><a href="#" class="btn btn-warning"><i class="fa fa-angle-left"></i> Continue Shopping</a></td>
                <td colspan="2" class="hidden-xs"></td>
                <td class="hidden-xs text-center" ><strong id="grandresult">Total #</strong></td>
                <td><a href="https://www.paypal.com/webapps/hermes?token=5EY097812P7754247&useraction=commit&mfid=1546377013907_cf1dec6830d7" class="btn btn-success btn-block">Checkout <i class="fa fa-angle-right"></i></a></td>
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
                        
                        $('#grandresult').html("Total $" + TotalValue+" :00");
                    }
                    
                    // TotalValue += parseFloat($(this).find('.totalprice').html());
                    });
                    
            });
                          
            }); 
      
    </script>
@endsection