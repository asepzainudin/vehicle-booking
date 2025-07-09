<?php

namespace App\Enums;

enum UserType: string
{
    case ADMIN = 'admin';
    case GENERAL = 'general';
    case DRIVER = 'driver';

    public function label(): string
    {
        return match ($this) {
            self::ADMIN => 'Admin',
            self::GENERAL => 'General',
            self::DRIVER => 'Driver',

            default => 'Tidak Diketahui',
        };
    }
}
