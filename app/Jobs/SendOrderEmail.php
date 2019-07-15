<?php

namespace App\Jobs;

use App\Helpers\SendMail;
use App\Order;
use App\ConfirmedCart;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendOrderEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $order;
    protected $cart;

    /**
     * Create a new job instance.
     *
     * @param Order $order
     * @param $cart
     * @return void
     */
    public function __construct(Order $order, $cart)
    {
        $this->order = $order;
        $this->cart = $cart;
    }

    /**
     * Execute the job.
     *
     * @param  \App\Helpers\SendMail $mail
     * @return void
     */
    public function handle(SendMail $mail)
    {
        $mail->orderMail(
            $this->order->client_first_name,
            $this->order->client_last_name,
            $this->order->phone,
            $this->cart,
            $this->order->total_price
        );

    }
}
