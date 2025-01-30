<?php

namespace App\Listeners;

use App\Models\Wallet;
use Illuminate\Auth\Events\Registered;

class CreateUserWallet
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
    }

    /**
     * Handle the event.
     */
    public function handle(Registered $event): void
    {
        Wallet::create([
            "user_id" => $event->user->getAuthIdentifier(),
        ]);
    }
}
