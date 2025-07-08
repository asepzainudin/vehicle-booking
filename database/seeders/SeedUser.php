<?php

namespace Database\Seeders;

use App\Models\Partner\Airline;
use App\Models\Travel\Travel;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class SeedUser extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ($this->data() as $_user) {
            if (empty($_user['password'])) {
                $_user['password'] = 'password';
            }
            $_user['email_verified_at'] = now();

            $user = User::query()->create(Arr::except($_user, ['role']));
            try {
                $user->assignRole($_user['role']);
            } catch (\Exception $e) {
                // throw_if()
            }
        }
    }

    private function data(): array
    {
        $data = [
            [
                'name' => 'Owner',
                'username' => 'owner',
                'email' => 'owner@' . config('app.email_suffix'),
                'role' => 'super-admin',
                'type' => 'admin',
            ],
            [
                'name' => 'Administrator',
                'username' => 'admin',
                'email' => 'admin@' . config('app.email_suffix'),
                'role' => 'admin',
                'type' => 'admin',
            ],
            [
                'name' => 'FOP APPROVAL',
                'username' => 'fop_approval.',
                'email' => 'fop_approval' . '@' . config('app.email_suffix'),
                'role' => 'fop_approval',
                'type' => 'fop',
            ],
            [
                'name' => 'FOP Maker',
                'username' => 'fop_maker.',
                'email' => 'fop_maker' . '@' . config('app.email_suffix'),
                'role' => 'fop_maker',
                'type' => 'fop',
            ],
            [
                'name' => 'Specialist ',
                'username' => 'specialist.',
                'email' => 'specialist' . '@' . config('app.email_suffix'),
                'role' => 'specialist',
                'type' => 'specialist',
            ],
            [
                'name' => 'RM ',
                'username' => 'rm_user',
                'email' => 'rm' . '@' . config('app.email_suffix'),
                'role' => 'rm',
                'type' => 'rm',
            ],
        ];

        Airline::query()
            ->select('id', 'code', 'name')
            ->get()
            ->each(function (Airline $partner) use (&$data) {
                $data[] = [
                    'name' => 'Maskapai ' . $partner->name,
                    'username' => 'maskapai.' . $partner->code,
                    'email' => 'maskapai.' . $partner->code . '@' . config('app.email_suffix'),
                    'role' => 'airline',
                    'partner_id' => $partner->id,
                    'type' => 'general',
                ];
            });
            
        Travel::query()
            ->select('id', 'code', 'name')
            ->get()
            ->each(function (Travel $travel) use (&$data) {
                $data[] = [
                    'name' => 'PiC PIHK ',
                    'username' => 'pic_pihk.' . $travel->code,
                    'email' => 'pic_pihk.' . $travel->code . '@' . config('app.email_suffix'),
                    'role' => 'pic_pihk',
                    'travel_id' => $travel->id,
                    'type' => 'pic_pihk',
                ];
            });

        return $data;
    }
}
