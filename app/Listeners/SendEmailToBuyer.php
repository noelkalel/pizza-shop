<?php

namespace App\Listeners;

use App\Events\OrderCreated;
use App\Mail\OrderConfirmation;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendEmailToBuyer
{
    public function handle(OrderCreated $event)
    {
        \Mail::to($event->order->email)->send(new OrderConfirmation($event->order));
    }
}
