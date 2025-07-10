<?php

namespace Database\Seeders;

use App\Enums\UserType;
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
                'name' => 'Approval User',
                'username' => 'approval',
                'email' => 'approval' . '@' . config('app.email_suffix'),
                'role' => 'approval',
                'type' => UserType::STAFF->value,
            ],
            [
                'name' => 'Reviewer User',
                'username' => 'reviewer',
                'email' => 'reviewer' . '@' . config('app.email_suffix'),
                'role' => 'reviewer',
                'type' => UserType::STAFF->value,
            ],
            [
                'name' => 'Driver user 1',
                'username' => 'driver1',
                'email' => 'driver1' . '@' . config('app.email_suffix'),
                'role' => 'driver',
                'type' => UserType::DRIVER->value,
            ],
            [
                'name' => 'Driver user 2',
                'username' => 'driver2',
                'email' => 'driver2' . '@' . config('app.email_suffix'),
                'role' => 'driver',
                'type' => UserType::DRIVER->value,
            ],
        ];

        return $data;
    }
}
