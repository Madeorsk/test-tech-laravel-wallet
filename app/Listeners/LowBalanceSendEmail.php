<?php

namespace App\Listeners;

use App\Events\LowBalanceEvent;
use App\Mail\LowBalanceEmail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class LowBalanceSendEmail
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
    public function handle(LowBalanceEvent $event): void
    {
        Mail::to($event->wallet->user)->send(new LowBalanceEmail($event->wallet));
    }
}
