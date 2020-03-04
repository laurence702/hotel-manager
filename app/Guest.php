<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Guest extends Model
{
    protected $table = "guests";

    protected $guarded = [
        'updated_at','deleted_at','cancelled_at'
    ];

    public function getFullNameAttribute()
    {
        return $this->firstname . ' ' . $this->lastname;
    }
}
