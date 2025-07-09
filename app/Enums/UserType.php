<?php

namespace App\Enums;

enum UserType: string
{
    case ADMIN = 'admin';
    case GENERAL = 'general';
    case DRIVER = 'driver';
    case STAFF = 'staff';

    public function label(): string
    {
        return match ($this) {
            self::ADMIN => 'Admin',
            self::GENERAL => 'General',
            self::DRIVER => 'Driver',
            self::STAFF => 'Staff',
            
            default => 'Tidak Diketahui',
        };
    }
}
