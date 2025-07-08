<?php

namespace App\Core\Notification\Listeners;

use App\Core\Notification\Events\NotifyCreated;
use Illuminate\Support\Facades\Artisan;

class NotifyOnCreated
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  NotifyCreated  $event
     *
     * @return void
     */
    public function handle(NotifyCreated $event): void
    {
        if ($event->channel == 'woowa' && $event->key) {
            Artisan::call('woowa:send', [
                '--key' => $event->key,
            ]);
        }
    }
}
