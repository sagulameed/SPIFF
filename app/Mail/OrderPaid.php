<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class OrderPaid extends Mailable
{
    use Queueable, SerializesModels;

    protected $order;
    protected $design;
    protected $numPieces;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($order, $design, $numPieces)
    {
        $this->order        = $order;
        $this->design       = $design;
        $this->numPieces    = $numPieces;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        Log::info('Sending email');
        return $this->subject("Your order is paid")
            ->view('mails.orderPaid')->with([
                'order'     => $this->order,
                'design'    => $this->design,
                'numPieces' => $this->numPieces
            ]);
    }
}
