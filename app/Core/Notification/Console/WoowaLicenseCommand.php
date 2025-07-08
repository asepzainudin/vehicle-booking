<?php

namespace App\Core\Notification\Console;

use App\Core\Notification\NotificationLicense;
use Exception;
use Illuminate\Console\Command;
use Throwable;

class WoowaLicenseCommand extends Command
{
    protected $signature = 'woowa:license ' .
        '{--seed : Seed from school-data}' .
        '{--clean : clean data, required using --seed}';

    protected $description = 'Add notification license';

    private string $cacheName = 'woowa:lic';
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
        $this->manual();
    }

    private function manual(): void
    {
        $this->line('');
        $this->info('Add new Notification\'s License');
        $this->line('');

        $name = $this->ask('license\'s name ?');
        $license = $this->ask('what is the license ?');
        $key = $this->ask('what is the license\' key ?');

        try {
            NotificationLicense::query()->create([
                'type' => $this->licenseType,
                'name' => $name,
                'license' => $license,
                'token' => $key,
            ]);

            $this->info('successfully added '. $license .' with key '. $key);

        } catch (Exception $e) {
            //
            // throw $e;
            $this->error($e->getMessage());
        }
    }
}
