<?php

namespace Database\Seeders;

use App\Vendor\Permission\Models\Permission;
use App\Vendor\Permission\Models\Role;
use Illuminate\Database\Seeder;

class SeedRbac extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ($this->data() as $role) {
            // Hindari duplikasi berdasarkan name dan guard_name
            $exists = Role::query()->where('name', $role['name'])
                ->where('guard_name', 'web')
                ->first();
            if (! $exists) {
                $role['guard_name'] = 'web';
                Role::query()->create($role);
            }
        }
        $roles = Role::query()->get()->keyBy('name');

        foreach ($this->permission() as $key => $permission) {

            $data['name'] = $permission['name'];
            $data['label'] = $permission['label'];

            Permission::query()->create($data);
            foreach ((array) $permission['role'] ?? [] as $key => $value) {
                $role = $roles->get($value);
                if ($role instanceof Role) {
                    $role->givePermissionTo($permission['name']);
                }
            }
        }
    }

    private function data(): array
    {
        return [
            //ADMIN CLIENT DAN OWNER
            [
                'name' => 'super-admin',
                'label' => 'Super Administrator',
                'type' => 'owner',
                'note' => 'Memiliki akses ke fitur'
            ],
            [
                'name' => 'admin',
                'label' => 'Administrator',
                'type' => 'client',
                'note' => 'Memiliki akses ke semua fitur, Mengelola akun dan profil '
            ],
            [
                'name' => 'approval',
                'label' => 'APPROVAL',
                'type' => 'client',
                'note' => 'Memiliki akses ke fitur approve'
            ],
            [
                'name' => 'reviewer',
                'label' => 'REVIEWER',
                'type' => 'client',
                'note' => 'Memiliki akses ke fitur reviewer'
            ],
            [
                'name' => 'driver',
                'label' => 'Driver',
                'type' => 'client',
                'note' => 'Memiliki akses ke fitur driver'
            ],
        ];
    }

    private function permission(): array
    {
        return  [
            //permission User
            [
                'name' => 'user.show',
                'label' => 'User show',
                'role' => ['admin', 'super-admin']
            ],
            [
                'name' => 'user.create',
                'label' => 'User create',
                'role' => ['admin', 'super-admin']
            ],
            [
                'name' => 'user.update',
                'label' => 'User update',
                'role' => ['admin', 'super-admin']
            ],
            [
                'name' => 'user.delete',
                'label' => 'User create',
                'role' => ['admin', 'super-admin']
            ],

            //permission Role
            [
                'name' => 'role.show',
                'label' => 'Role show',
                'role' => ['admin', 'super-admin']
            ],
        ];
    }
}
