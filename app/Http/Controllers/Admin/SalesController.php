<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Sale;
use App\Product;
use App\Cart;
use Carbon\Carbon;

class SalesController extends Controller
{
    public function sellDrinks(Request $request) {
        $purchases=$request->all();
        
        $invoiceId = $this->generateInvoiceId();
        foreach($purchases['order'] as $purchase){
            $sale = new Sale;
            $sale->unit_price = (int)$purchase['unit_price'];
            $sale->product = $purchase['drink_name'];
            $sale->quantity=(int)$purchase['qty'];
            $sale->value=(int)$purchase['total']; 
            $sale->invoice_number = $invoiceId;
            $sale->soldBy = trim($purchase['soldBy']);
            
            $sale->save();
     
        }

        //get last record 
        $dataRecord = Sale::where('invoice_number',$invoiceId)->get();

        return response()->json([
            'status' => true,
            'data' => $dataRecord,
            'message'   => 'Success',
        ]);
    }

    public function generateInvoiceId(){
        return '#'.str_shuffle('12RBHZ367890#DQE');
    }


    public function generateInvoice() {
        return view('admin.products.receipt-template2');
    }


    public function getLastRecord(){
        $orderDetails=Sale::orderBy('created_at','DESC')
                            ->first();

        $i_id = $orderDetails['invoice_number'];

        $lastInvoiceId = Sale::where('invoice_number',$i_id)->get();
        $total = 0;
        foreach($lastInvoiceId as $iid){
            
            $total += $iid['value'];
        }
       
        $twt = $total + ($total * 0.05);
        return response()->json([
            'status' => true,
            'data'   => $lastInvoiceId,
            'total'  => $total,
            'TotalwithTax' =>$twt,
            'taxAmount' => (int) $total * 0.05
        ]);
    }

    //Get Last Record
    public function getLastCart()
    {
        $cartItems =  DB::table('cart')->insertGetId(
            [ 'product_id' => 'first' ]
        );

        dd($cartItems);
    }

    public function createCart(Request $request) {
        //save ids of products
        //send response and then frontend will redirect and fetch last record
        $product_ids = $request->all(); 
        
        $cartCode = $this->generateInvoiceId();
        foreach($product_ids as $product_ids)
        {
            $cart = new Cart;
            $cart->cart_code = $cartCode;
            $cart->product_id = $product_ids;
            $qSucess = $cart->save(); 
        }

        //$products = Product::whereIn('id',$product_ids)->get();
        $cartId = $cart->id;
        return response()->json([
            'status' => true,
            'last_cart_code'   => $cartCode
        ]);
    }

    public function getCartItems(Request $request)
    {
       return $res = Cart::all();
    }

    public function showAllSales(Request $request)
    {
        $sales = Sale::orderBy('created_at','desc')->get();
        $numberSoldToday = Sale::select('value')->whereDay('created_at',date('d'))->count();
        $salesToday = Sale::select('value')->whereDay('created_at',date('d'))->sum('value');
        return view('admin.products.saleshistory', compact('sales','salesToday','numberSoldToday'));
    }

    
    public function getSelectedProducts(Request $request) {
      
        $product_ids = $request->all();
        $products_selected = Product::whereIn('id',$product_ids)->get()->toarray();
          
        return $products_selected;
                
    }

    public function checkoutPage(Request $request) {

        return view('admin.products.drinkscheckout');
    }
    
}
