<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class GiftVoucher extends Model
{
    protected $table = 'discount_voucher';

    protected $fillable = [
        'voucher_code','amount','is_used','user_id','customer_id',
    ];
    protected $dates = ['created_at','updated_at','deleted_at'];

    public function customer()
    {
        return $this->belongsToOne(Customer::class,'customer_id')->withTrashed();
    }
    
    public function generateVoucherWithCode($request) {
        if(isset($request->voucher_code))
            $voucherCode=$request->voucher_code;
        else
            $voucherCode=Str::random();
        $voucherCount = GiftVoucher::where('voucher_code',$request->voucher_code)->count();
        if($voucherCount >= 1)
            return response()->json(['status' => true,'message' => 'Voucher already exists'],401);
        else
            $newVoucher = new GiftVoucher;
            $newVoucher->amount = $request->amount;
            $newVoucher->voucher_code=$voucherCode;
            $newVoucher->save();
        return response()->json(['status' => true,'message' => 'Voucher created'],202);
    }

}
