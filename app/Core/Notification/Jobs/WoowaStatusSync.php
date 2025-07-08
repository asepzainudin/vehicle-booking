<?php

namespace App\Core\Notification\Jobs;

use App\Core\Notification\NotificationLog;
use App\Core\Notification\NotifyStatus;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Fluent;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Throwable;

class WoowaStatusSync implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    private string $key;
    private ?string $license = null;
    private ?bool $isSink = null;
    public static string $cacheName = 'woowa:sync-status:';
    private static int $count = 0;

    public function __construct(string $key, ?string $license = null, ?bool $isSink = null)
    {
        $this->key = $key;
        $this->license = $license;
        $this->isSink = $isSink;
    }

    /**
     * Get the tags that should be assigned to the job.
     *
     * @return array
     */
    public function tags(): array
    {
        return ['notification', 'whatsapp', 'woowa', 'woowa-sync', 'woowa-lic:'.$this->license];
    }

    /**
     * @return void
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws Throwable
     */
    public function handle(): void
    {
        if ($this->cache()) {
            return;
        }
        $this->cache('set');

        if ($this->cacheMode('is-sink')) {
            // dump('stream');
            $this->sink();
        } else {
            // dump('bundling');
            $this->bundle();
        }

        $this->cache('forget');
    }

    /**
     * The job failed to process.
     *
     * @param  Exception  $exception
     *
     * @return void
     */
    public function failed(Exception $exception): void
    {
        $this->cache('forget');
    }

    /**
     * @return void
     * @throws Throwable
     */
    private function sink(): void
    {
        $logQuery = NotificationLog::query()
            ->whereIn('channel', ['woowa', 'woowa_eco'])
            ->where('sender', $this->key)
            ->where('status', NotifyStatus::AWAIT)
            ->whereNotNull('resp_id')
            ->whereRaw("resp_id ~ '^\d+$'")
            ->orderBy('created_at')
            ->limit(500);
        $x = 0;

        while ($x < 3 && self::$count < 500) {
            $logQuery
                ->get()
                ->each(function (NotificationLog $log) {
                    try {
                        // dump([
                        //     'key' => $this->key,
                        //     'msg_id' => $log->resp_id,
                        // ]);

                        $req = $this->http()->post('status_msg_id', [
                            'json' => [
                                'key' => $this->key,
                                'msg_id' => $log->resp_id,
                            ],
                        ]);

                        $status = (string) json_decode($req->body()) ?? '';
                        // dump($req->getBody()->getContents(), $status);

                        if (!empty($status)) {
                            $log->update([
                                'resp_status' => $status,
                                'channel_status' => $status,
                                'status' => str($status)->contains('success', true)
                                    ? NotifyStatus::SUCCESS
                                    : NotifyStatus::FAIL,
                            ]);
                        }
                    } catch (Exception $e) {
                        //
                        throw_if(debugNonProduction(), $e);
                    }

                    ++self::$count;
                });

            ++$x;
        }
    }

    /**
     * @return void
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    private function bundle(): void
    {
        $logTable = new NotificationLog()->getTable();

        // dump('loh kok bundle');

        try {
            $req = $this->http()->post('report_json', [
                'json' => [
                    'key' => $this->key,
                    'time_choose' => 'today',
                ],
            ]);

            try {
                $body = new Fluent($req->json());
            } catch (Exception $e) {
                $body = new Fluent([]);
            }

            $i = 0;
            foreach ($body->get('data') as $data) {
                ++$i;
                if (property_exists($data, 'message_id') && property_exists($data, 'status')) {
                    DB::table($logTable)
                        ->where('status', NotifyStatus::AWAIT)
                        ->where('resp_id', $data->message_id)
                        ->update([
                            'resp_status' => $data->status,
                            'channel_status' => $data->status,
                            'status' => str($data->status)->contains('success', true)
                                ? NotifyStatus::SUCCESS
                                : NotifyStatus::FAIL,
                            'updated_at' => now(),
                        ]);
                }
            }

            if ($i >= 500) {
                $this->cacheMode('set', 'sink');
            }

        } catch (Exception $e) {
            if (stripos($e->getMessage(), 'operation timed out') !== false) {
                $this->cacheMode('set', 'sink');
            }
        }
    }

    /**
     * @param  string  $mode
     *
     * @return bool
     */
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

    /**
     * @param  string  $mode
     * @param  bool  $sink
     *
     * @return bool
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    private function cacheMode(string $mode = 'has', bool $sink = false): bool
    {
        $cacheName = self::$cacheName.'mode:'.$this->license;
        if ($mode == 'set') {
            app('cache')->put($cacheName, $sink ? 'sink' : 'bundle', now('Asia/Jakarta')->endOfDay());
            return true;
        }
        if ($mode == 'has') {
            return app('cache')->has($cacheName);
        }
        if ($mode == 'is-sink') {
            if (! is_null($this->isSink)) {
                return $this->isSink;
            }
            return app('cache')->has($cacheName)
                && app('cache')->get($cacheName) == 'sink';
        }
        if ($mode == 'forget') {
            return app('cache')->forget($cacheName);
        }
        return false;
    }

    /**
     * @return PendingRequest
     */
    private function http(): PendingRequest
    {
        $baseUrl = preg_replace('/\/+$/', '', config('woowa.base_url'));
        return Http::baseUrl($baseUrl)->withOptions([
            'verify' => false,
            'timeout' => 180,   // 3 menit
            'debug' => false,
            // 'on_stats' => function (TransferStats $stats) {
            //     // You must check if a response was received before using the
            //     // response object.
            //     if ($stats->hasResponse()) {
            //         dump([
            //             $stats->getResponse()->getStatusCode(),
            //             $stats->getResponse()->getBody()->getContents(),
            //         ]);
            //     } else {
            //         // Error data is handler specific. You will need to know what
            //         // type of error data your handler uses before using this
            //         // value.
            //         dump($stats->getHandlerErrorData());
            //     }
            // }
        ]);
    }
}
