<?php

namespace App\Enums;

enum StatusType: string
{
    case REVIEW = 'review';
    case APPROVED = 'approved';
    case REJECTED = 'rejected';
    case RETURN = 'return';

    public function label(): string
    {
        return match ($this) {
            self::REVIEW => 'REVIEW',
            self::APPROVED => 'APPROVED',
            self::REJECTED => 'REJECTED',
            self::RETURN => 'RETURN',

            default => 'Tidak Diketahui',
        };
    }
}
