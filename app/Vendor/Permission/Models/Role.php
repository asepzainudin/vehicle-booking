<?php

namespace App\Vendor\Permission\Models;

use Spatie\Permission\Contracts\Role as RoleContract;
use Spatie\Permission\Guard;
use Spatie\Permission\PermissionRegistrar;
use Veelasky\LaravelHashId\Eloquent\HashableId;

class Role extends \Spatie\Permission\Models\Role
{
    use HashableId;

    /**
     * @param string $name
     * @param string|null $label
     * @param string|null $guardName
     * @param string|null $note
     * @return RoleContract
     */
    public static function findOrCreate(string $name, string|null $label = null, string|null $guardName = null , string|null $note = null): RoleContract
    {
        $guardName = $guardName ?? Guard::getDefaultName(static::class);

        $role = static::findByParam(['name' => $name, 'guard_name' => $guardName]);

        if (! $role) {
            if (! $label) {
                $label = $name;
            }
            return static::query()
                ->create(
                    ['name' => $name, 'label' => $label, 'guard_name' => $guardName, 'note' => $note] +
                    (app(PermissionRegistrar::class)->teams ? [app(PermissionRegistrar::class)->teamsKey => getPermissionsTeamId()] : [])
                );
        }

        return $role;
    }
}
