<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Sale;
use Carbon\Carbon;

class SalesController extends Controller
{
    public function sellDrinks(Request $request) {
         $purchases=$request->all();
        
         $invoiceId = $this->generateInvoiceId();
        foreach($purchases['order'] as $purchase){
            $sale = new Sale;
            $sale->product = 'Coca-Cola';
            $sale->quantity=$purchase['qty'];
            $sale->value=$purchase['total']; 
            $sale->invoice_number = $invoiceId;
            $sale->save();
     
        }
        //get last record 
        $dataRecord = Sale::where('invoice_number',$invoiceId)->get();

        return $dataRecord;

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
        return view('admin.products.show');
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
}
