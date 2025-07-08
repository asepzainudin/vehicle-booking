<?php

namespace App\Core\Notification\Console;

use App\Core\Notification\Concerns\HasLog;
use App\Core\Notification\NotificationLicense;
use App\Core\Notification\Jobs\WoowaSender;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Throwable;

class WoowaHookCommand extends Command
{
    use HasLog;

    protected $signature = 'woowa:hook '.
        '{key : Woo-Wa key} '.
        '{--mode= : Hook mode. available values are [get, set, and unset]. default on "<info>get</info>"} '.
        '{--url= : Hook url target. required and only available on mode "<info>set</info>"} ';

    protected $description = 'Woo-Wa webhook service';

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
        $mode = $this->option('mode') ?? 'get';

        if (in_array($mode, ['get', 'set', 'unset'])) {
            $this->doAction($mode);
        } else {
            $this->components->error('invalid mode. available values are <info>get</info>, <info>set</info>, <info>unset</info>');
        }
    }

    private function doAction(string $action): void
    {
        $data = [
            'key' => $this->argument('key'),
            'action' => $action,
        ];
        if ($action === 'set') {
            $data['url'] = $this->option('url');
            if (empty($data['url'])) {
                $this->components->error("[<info>{$action}</info>] failed 400 - target url is empty. use <info>--url</info> option to set the url");
                return;
            }
        }

        $resp = Http::baseUrl(preg_replace('/\/+$/', '', config('msnotif.driver.woowa.host')))
            ->withoutRedirecting()
            ->acceptJson()
            ->withoutVerifying()
            ->timeout(60)
            ->post('webhook', $data);

        // dump($resp->body(), $resp->json(), $resp->status(), $resp->successful());
        // available response json status [success, failed, processing]

        $message = $resp->json('status') ? $resp->json('message') : $resp->body();
        if (empty($message)) {
            $message = $resp->reason();
        }

        if ($resp->successful()) {
            if ($resp->ok()) {
                $messagePrefix = match ($action) {
                    'get' => 'hook target on ',
                    'set' => 'successfully set webhook target on ',
                    default => '',
                };
                $this->components->info("[<info>{$action}</info>] {$messagePrefix}{$message}");
            } else {
                $this->components->warn("[<info>{$action}</info>] {$message}");
            }
        } else {
            $this->components->error("[<info>{$action}</info>] failed {$resp->status()} - {$message}");
        }
    }
}
