<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class DiscountgivenNotification extends Mailable
{
    use Queueable, SerializesModels;
    public $discountPrice;
    public $AmountDue;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($discountPrice,$AmountDue)
    {
        $this->discountPrice = $discountPrice;
        $this->$AmountDue = $AmountDue;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('thrivemaxhotel@gmail.com')->view('mails.anomaly');
    }
}
