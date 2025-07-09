<?php

namespace Database\Seeders;

use App\Vendor\Permission\Models\Permission;
use App\Vendor\Permission\Models\Role;
use Illuminate\Database\Seeder;

class SeedPermission extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = Role::query()->get()->keyBy('name');

        foreach ($this->permission() as $key => $permission) {
            Permission::query()->updateOrCreate(['name' => $permission['name']], ['label' => $permission['label']]);
            foreach ((array) $permission['role'] ?? [] as $key => $value) {
                $role = $roles->get($value);
                if ($role instanceof Role) {
                    $role->givePermissionTo($permission['name']);
                }
            }
        }
    }
    private function permission(): array
    {
        //Permission Office Region
        $officeRegion = [
            'office-region' =>  ['show', 'create', 'update', 'delete'],
            'mine' => ['show', 'create', 'update', 'delete'],
        ];

        foreach ($officeRegion as $keyRegion => $_region) {
            foreach ($_region as $key => $type) {
                $permission[] = [
                    'name' => $keyRegion . '.' . $type,
                    'label' => ucfirst($keyRegion)  . ' ' . $type,
                    'role' => ['admin', 'super-admin']
                ];

                if ($type == 'show') {
                    $permission[] = [
                        'name' => $keyRegion . '.' . $type,
                        'label' => ucfirst($keyRegion)  . ' ' . $type,
                        'role' => ['approval', 'reviewer']
                    ];
                }
            }
        }
        
        //Permission Vehicle
        $vehicle = [
            'dashboard' => ['show'],
            'vehicle' => ['show', 'create', 'update', 'delete'],
            'vehicle-order' => ['show', 'create', 'update', 'delete', 'status'],
        ];

        foreach ($vehicle as $keyVehicle => $_travel) {
            foreach ($_travel as $key => $type) {
                $permission[] = [
                    'name' => $keyVehicle . '.' . $type,
                    'label' => ucfirst($keyVehicle)  . ' ' . $type,
                    'role' => ['admin', 'super-admin']
                ];
                if ($type == 'show' || $type == 'status') {
                    $permission[] = [
                        'name' => $keyVehicle . '.' . $type,
                        'label' => ucfirst($keyVehicle)  . ' ' . $type,
                        'role' => ['approval', 'reviewer']
                    ];
                }
            }
        }

        return $permission;
    }
}
