<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OnlineBooking extends Model
{
    use SoftDeletes;
    protected $table = "room_booking";

    protected $guarded = [
        "created_at","updated_at","deleted_at"
    ];

    public function guest()
    {
        return $this->belongsTo(Guest::class, 'guest_id');
    }

    public function room()
    {
        return $this->belongsTo(Room::class, 'room_id');
    }
}
