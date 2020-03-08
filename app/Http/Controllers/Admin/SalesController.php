<?php

namespace App\Http\Controllers\Admin;

use DB;
use App\Cart;
use App\Sale;
use App\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SalesController extends Controller
{
    public function sellDrinks(Request $request)
    {
        $purchases = $request->all();
        $invoiceId = $this->generateInvoiceId();
        foreach ($purchases['order'] as $key => $purchase) {
            $sale = new Sale;
            $numberPurchased = $purchase['qty'];
            $prod_id = $purchase['product_id'];
            $sale->productId = (int) $prod_id;
            $sale->unit_price = (int) $purchase['unit_price'];
            $sale->product = $purchase['drink_name'];
            $sale->quantity = (int) $numberPurchased;
            $sale->value = (int) $purchase['total'];
            $sale->invoice_number = $invoiceId;
            $sale->soldBy = trim($purchase['soldBy']);
            $sale->save();
            $newStockCount = Product::where('id', $prod_id)->decrement('stock_count', $numberPurchased); //decrease stock                                       
        }
        $dataRecord = Sale::where('invoice_number', $invoiceId)->get();
        return response()->json(['status' => true, 'data' => $dataRecord, 'message' => 'Success']);
    }

    public function generateInvoiceId()
    {
        return '#' . str_shuffle('12RBHZ367890#DQE');
    }

    public function generateInvoice()
    {
        return view('admin.products.receipt-template2');
    }


    public function getLastRecord()
    {
        $orderDetails = Sale::orderBy('created_at', 'DESC')->first();
        
        $i_id = $orderDetails['invoice_number'];

        $lastInvoiceId = Sale::where('invoice_number', $i_id)->get();
        $total = 0;
        foreach ($lastInvoiceId as $iid) {

            $total += $iid['value'];
        }

        $twt = $total + ($total * 0.05);
        return response()->json([
            'status' => true,
            'data'   => $lastInvoiceId,
            'total'  => $total,
            'TotalwithTax' => $twt,
            'taxAmount' => (int) $total * 0.05
        ]);
    }


    //SORTABLE DATATABLE
    function showAllSales(Request $request)
    {
        $sales = Sale::orderBy('created_at', 'desc')->get();
        $numberSoldToday = Sale::select('value')->whereDay('created_at', date('d'))->count();
        $salesToday = Sale::select('value')->whereDay('created_at', date('d'))->sum('value');
        return view('admin.products.saleshistory', compact('sales', 'salesToday', 'numberSoldToday'));
    }


    public function getSelectedProducts(Request $request)
    {
        $product_ids = $request->all();
        $products_selected = Product::whereIn('id', $product_ids)->get()->toarray();

        return $products_selected;
    }

    public function checkoutPage(Request $request)
    {

        return view('admin.products.drinkscheckout');
    }
}
