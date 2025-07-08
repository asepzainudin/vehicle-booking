<?php

namespace App\Vendor\Permission\Models;

use Spatie\Permission\Contracts\Permission as PermissionContract;
use Spatie\Permission\Exceptions\PermissionAlreadyExists;
use Spatie\Permission\Guard;
use Veelasky\LaravelHashId\Eloquent\HashableId;

class Permission extends \Spatie\Permission\Models\Permission
{
    use HashableId;

    /**
     * @param array $attributes
     * @return PermissionContract|Permission
     *
     * @throws PermissionAlreadyExists
     */
    public static function create(array $attributes = []): PermissionContract|Permission
    {
        $attributes['guard_name'] = $attributes['guard_name'] ?? Guard::getDefaultName(static::class);

        $permission = static::getPermission(['name' => $attributes['name'], 'guard_name' => $attributes['guard_name']]);

        if ($permission) {
            throw PermissionAlreadyExists::create($attributes['label'] ?? $attributes['name'], $attributes['guard_name']);
        }

        return static::query()->create($attributes);
    }

    /**
     * @param string $name
     * @param string|null $label
     * @param string|null $guardName
     * @return PermissionContract
     */
    public static function findOrCreate(string $name, string|null $label = null, string|null $guardName = null): PermissionContract
    {
        $guardName = $guardName ?? Guard::getDefaultName(static::class);
        $permission = static::getPermission(['name' => $name, 'guard_name' => $guardName]);

        if (! $permission) {
            if (! $label) {
                $label = $name;
            }
            return static::query()->create(['name' => $name, 'label' => $label, 'guard_name' => $guardName]);
        }

        return $permission;
    }
}
