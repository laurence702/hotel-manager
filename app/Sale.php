<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected  $table= 'sales';

    protected $fillable = ['product','product_id' ,'unit_price','quantity','value', 'invoice_number','soldBy'];

    protected $dates = ['created_at','updated_at', 'deleted_at'];
}
