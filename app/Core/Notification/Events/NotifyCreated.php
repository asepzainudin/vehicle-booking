<?php

namespace App\Core\Notification\Events;

class NotifyCreated
{
    /** @var string|null */
    public ?string $channel = null;

    /** @var string|null */
    public ?string $key = null;

    public function __construct(?string $channel, ?string $key)
    {
        $this->channel = $channel;
        $this->key = $key;

        // app('log')->info('fire event '.__CLASS__.' => '.$channel.': '.$key);
    }
}
