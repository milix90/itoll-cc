<?php

namespace App\Listeners;

use App\Events\OrderStatusHandlerEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class EmitOrderStatusByEmail
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(OrderStatusHandlerEvent $event): void
    {
        /*foreach ($event->emails as $mail) {
            // todo: call email driver here to send email
        }*/
    }
}
