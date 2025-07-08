<?php

namespace App\Core\Bus;

use App\Core\Notification\NotificationLicense;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Fluent;

/**
 * Notification abstract.
 *
 * @author    yusron arif <yusron.arif4@gmail.com>
 */
abstract class AbstractNotification
{
    use Dispatchable, Queueable, InteractsWithQueue;

    /**
     * @var User
     */
    protected User $user;

    /**
     * @var array|string[]
     */
    protected array $tags = [];

    /**
     * Create a new notification instance.
     */
    public function __construct(User $user)
    {
        // $this->queue = 'notification';
        // $this->queue = 'priority';
        $this->user = $user;
    }

    /**
     * Get the tags that should be assigned to the job.
     *
     * @return array
     */
    public function tags(): array
    {
        return array_merge(['notification'], $this->tags);
    }

    protected function userData(): Fluent
    {
        $user = $this->user->only([
            'id', 'partner_id', 'name', 'username', 'phone',
            'timezone', 'locale',
            'created_at', 'created_by',
        ]);
        if (!$user['phone']) {
            $user['phone'] = '';
        }
        $user['wa_channel'] = config('msnotif.channel');
        $user['wa_lic'] = null;
        $user['wa_key'] = config('msnotif.driver.woowa.sender');
        if ($user['partner_id'] ?? null) {
            $keys = app('cache')->remember(
                'notify-lic-'.$user['partner_id'],
                now(clientTimezone())->endOfDay(),
                function () use ($user): Collection {
                    return NotificationLicense::query()
                        ->select('id', 'name', 'license', 'token as key')
                        ->where('type', $user['wa_channel'])
                        ->where('status', 'active')
                        ->where('partner_id', $user['partner_id'])
                        ->get();
                });
            // $user['wa_lic'] = $keys?->random() ?? null;
            $user['wa_key'] = $user['wa_lic']?->key ?? '';
        }

        return new Fluent($user);
    }
}
