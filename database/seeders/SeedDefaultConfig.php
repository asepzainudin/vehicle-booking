<?php

namespace Database\Seeders;

use App\Core\Notification\NotificationLicense;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class SeedDefaultConfig extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->woowaLic();
    }

    private function woowaLic(): void
    {
        $data = [
            [
                'type' => 'woowa',
                'name' => 'Default Woowa License',
                'license' => '5ee317334e704',
                'token' => 'adp9972ae29-6a18-4e6b-8960-d2a1f958eb1f'
            ],
        ];

        // collect($data)->each(function ($d) {
        //     NotificationLicense::query()->create($d);
        // });
    }
}
