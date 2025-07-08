<?php

namespace App\Enums;

enum UserType: string
{
    case ADMIN = 'admin';
    case GENERAL = 'general';
    case PICPIHK = 'pic_pihk';
    case RM = 'rm';
    case SPECIALIST = 'specialist';
    case FOP = 'fop';

    public function label(): string
    {
        return match ($this) {
            self::ADMIN => 'Admin',
            self::GENERAL => 'General',
            self::PICPIHK => 'PiC PIHK',
            self::RM => 'RM',
            self::SPECIALIST => 'Specialist',
            self::FOP => 'FOP',

            default => 'Tidak Diketahui',
        };
    }
}
