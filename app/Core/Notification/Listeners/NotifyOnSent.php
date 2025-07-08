<?php

namespace App\Core\Notification\Listeners;

use App\Core\Notification\Events\NotifySent;
use Illuminate\Support\Facades\Artisan;

class NotifyOnSent
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
     * @param  NotifySent  $event
     *
     * @return void
     */
    public function handle(NotifySent $event): void
    {
        if ($event->channel == 'woowa' && $event->key) {
            Artisan::call('woowa:sync-status', [
                '--key' => $event->key,
                '--sink' => true,
            ]);
        }
    }
}
