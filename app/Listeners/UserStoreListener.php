<?php

namespace App\Listeners;

use App\Events\UserStore;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UserStoreListener
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
    public function handle(UserStore $event): void
    {
        $user = $event->user;
        $user->addresses()->create([
            'address' => 'Sample Address ' . rand(1, 100),
        ]);
    }
}
