<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected  $table= 'sales';

    protected $fillable = ['product','quantity','value', 'invoice_number'];

    protected $dates = ['created_at','updated_at', 'deleted_at'];
}
