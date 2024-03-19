<?php

namespace App\Listeners;

use App\Events\UserUpdate;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UserUpdateListener
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
    public function handle(UserUpdate $event): void
    {
        $user = $event->user;
        $user->addresses()->create([
            'address' => 'Sample Address ' . rand(1, 100),
        ]);
    }
}
