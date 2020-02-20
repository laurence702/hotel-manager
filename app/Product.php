<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;
    protected $table = 'products';

    //protected $fillabe = ['name', 'price', 'description'];
    protected $guarded = [];

    protected $dates = ['created_at','updated_at','deleted_at'];
}
