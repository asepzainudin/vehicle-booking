<?php

namespace App\Core\Notification\Jobs;

use App\Core\Notification\Events\NotifyCreated;
use App\Core\Notification\Events\NotifySent;
use App\Core\Notification\NotificationLog;
use App\Core\Notification\NotifySendAction;
use App\Core\Notification\NotifyStatus;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Throwable;

class WoowaSender implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    public static string $cacheName = 'woowa:send:';
    public static string $lockName = 'woowa:send:lock';

    public function __construct(
        private readonly string $key,
        private readonly string|null $license = null
    ) {
        static::$lockName = static::$cacheName."{$this->key}:lock";
    }

    /**
     * Get the tags that should be assigned to the job.
     *
     * @return array
     */
    public function tags(): array
    {
        return ['notification', 'whatsapp', 'woowa', 'woowa-send', 'woowa-lic:'.$this->license];
    }

    public function handle(): void
    {
        if ($this->cache()) {
            return;
        }
        $this->cache('set');
        if (isAtomicLockSupport()) {
            app('cache')->lock(static::$lockName)->release();
        }

        $logs = NotificationLog::query()
            ->whereIn('channel', ['woowa', 'woowa_eco'])
            ->where('sender', $this->key)
            ->whereIn('status', [NotifyStatus::PENDING->value, NotifyStatus::TIMEOUT->value])
            ->orderBy('created_at')
            ->limit(500)
            ->get();

        $logsCount = $logs->count();
        foreach ($logs as $x => $log) {
            if (isAtomicLockSupport()) {
                app('cache')
                    ->lock(static::$lockName)
                    ->get(function () use ($log) {
                        $this->send($log);
                        app('cache')->lock(static::$lockName)->release();
                    });
            } else {
                $this->send($log);
            }
        }

        $this->cache('forget');

        // sleep(3);
        event(new NotifySent('woowa', $this->key));

        if ($logsCount > 0) {
            // try to re-checking next 500
            event(new NotifyCreated('woowa', $this->key));
        }
    }

    /**
     * The job failed to process.
     *
     * @param  Throwable|null  $exception
     *
     * @return void
     */
    public function failed(Throwable|null  $exception): void
    {
        $this->cache('forget');
    }

    private function send(NotificationLog $log): void
    {
        // $param = [
        //     "sender" => $log->sender,
        //     "recipient" => $log->receiver,
        //     "channel" => $log->channel,
        //     "content" => $log->content,
        // ];

        $action = new NotifySendAction(
            processId: $log->process_id,
            tags: []
        );
        $action->sendIt();
    }

    private function cache(string $mode = 'has'): bool
    {
        $cacheName = self::$cacheName.$this->license;
        if ($mode == 'set') {
            app('cache')->put($cacheName, true, now('Asia/Jakarta')->addHour());
            return true;
        }
        if ($mode == 'has') {
            return app('cache')->has($cacheName);
        }
        if ($mode == 'forget') {
            return app('cache')->forget($cacheName);
        }
        return false;
    }
}
