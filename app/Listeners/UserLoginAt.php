<?php

declare(strict_types=1);

namespace App\Listeners;

use Carbon\Carbon;
use Illuminate\Auth\Events\Login;

final class UserLoginAt
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Handle the event.
     */
    public function handle(Login $event): void
    {
        $event->user->update([
            'last_login_at' => Carbon::now(),
        ]);
    }
}
