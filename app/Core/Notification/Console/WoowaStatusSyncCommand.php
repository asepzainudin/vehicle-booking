<?php

namespace App\Core\Notification\Console;

use App\Core\Notification\Concerns\HasLog;
use App\Core\Notification\Jobs\WoowaStatusSync;
use App\Core\Notification\NotificationLicense;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Builder;
use Throwable;

class WoowaStatusSyncCommand extends Command
{
    use HasLog;

    protected $signature = 'woowa:sync-status ' .
        '{--key= : Direct sending using this key}'.
        '{--sink : Force to sink/single method syncronize}'.
        '{--check : check running status}'.
        '{--reset : Reset locking status}';

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
        $check = $this->option('check');
        $reset = $this->option('reset');

        if ($check || $reset) {
            $this->licQuery()
                ->addSelect('name')
                ->get()
                ->each(function (NotificationLicense $lic) use ($check, $reset) {
                    $msg = "Lisensi {$lic->license} | {$lic->name}";
                    $cacheName = WoowaStatusSync::$cacheName . $lic->license;
                    if ($check) {
                        $msg .= ' => '. (app('cache')->has($cacheName) ? '<info>already running</info>' : '<comment>stopped</comment>');
                    }
                    if ($reset) {
                        if (app('cache')->forget($cacheName)) {
                            $msg .= ' => <comment>successfully reset</comment>';
                        } else {
                            $msg .= ' => <error>reset was failed</error>';
                        }
                    }

                    $this->line($msg);
                });

            return;
        }

        $key = $this->option('key');

        if ($key) {
            $lic = app('cache')->remember(
                'woowa:lic-via-key:'.$key,
                now('Asia/Jakarta')->endOfDay(),
                fn () => $this->licQuery()->where('token', $key)->first()
            );

            if ($lic instanceof NotificationLicense) {
                $this->info('send single key');
                $this->sync($lic);
            } /*else {
                app('cache')->forget('woowa:lic-via-key:'.$key);
            }*/

            return;
        }

        $this->licQuery()
            ->get()
            ->each(function (NotificationLicense $lic) {
                $this->sync($lic);
                // app('cache')->remember($this->cacheName . $lic->license, now()->addDay(), function () {})
            });
    }

    private function licQuery(): Builder
    {
        return NotificationLicense::query()
            ->select('license', 'token')
            ->where('type', $this->licenseType)
            ->where(function ($qry) {
                $qry->whereNull('expires_at')
                    ->orWhere('expires_at', '>=', now('Asia/Jakarta'));
            });
    }

    private function sync(NotificationLicense $lic): void
    {
        $msg = null;
        if (app('cache')->has(WoowaStatusSync::$cacheName.$lic->license)) {
            $msg = 'skip sync - the licence '.$lic->license.' already running';
            $this->warn($msg);
        } else {
            //
            dispatch(new WoowaStatusSync(
                $lic->token,
                $lic->license,
                $this->option('sink')
            ))->onQueue('notification_sync');
                // ->delay(now('Asia/Jakarta')->addSeconds(30));
            $msg = 'successfully run syncing the licence '. $lic->license;
        }
        if ($msg) {
            static::logInfo($msg);
        }
    }
}
