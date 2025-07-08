<?php

namespace App\Core\Notification\Console;

use App\Core\Notification\Concerns\HasLog;
use App\Core\Notification\NotificationLicense;
use App\Core\Notification\Jobs\WoowaSender;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Builder;
use Throwable;

class WoowaSendingCommand extends Command
{
    use HasLog;

    protected $signature = 'woowa:send {--key= : Direct sending using this key}';

    protected $description = 'Send notification to WhatsApp vendor service';

    private string $licenseType = 'woowa';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @return void
     * @throws Throwable
     */
    public function handle(): void
    {
        $key = $this->option('key');

        if ($key) {
            $lic = app('cache')->remember(
                'woowa:lic-via-key:'.$key,
                now('Asia/Jakarta')->endOfDay(),
                fn () => $this->licQuery()->where('token', $key)->first()
            );

            if ($lic instanceof NotificationLicense) {
                $this->info('send single key');
                $this->send($lic);
            } /*else {
                app('cache')->forget('woowa:lic-via-key:'.$key);
            }*/

        } else {
            $this->licQuery()
                ->get()
                ->each(function (NotificationLicense $lic) {
                    $this->send($lic);
                    // app('cache')->remember($this->cacheName . $lic->license, now()->addDay(), function () {})
                });
        }

        $this->info('send success');
    }

    private function licQuery(): Builder
    {
        return NotificationLicense::query()
            ->select('license', 'token')
            ->where('type', $this->licenseType)
            ->where(function ($qry) {
                $qry
                    ->whereNull('expires_at')
                    ->orWhere('expires_at', '>=', now('Asia/Jakarta'));
            });
    }

    private function send(NotificationLicense $lic): void
    {
        $msg = null;
        if (app('cache')->has(WoowaSender::$cacheName . $lic->license)) {
            $msg = 'skip sending - the licence '. $lic->license .' already running';
            $this->warn($msg);
        } else {
            //
            dispatch(new WoowaSender(
                $lic->token,
                $lic->license
            ))->onQueue('notification');
            $msg = 'successfully run sending the licence '. $lic->license;
        }
        if ($msg) {
            static::logInfo($msg);
        }
    }
}
