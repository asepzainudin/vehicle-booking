<?php

namespace App\Enums;

enum StatusType: string
{
    case REVIEW = 'review';
    case APPROVED = 'approved';
    case REJECTED = 'rejected';

    public function label(): string
    {
        return match ($this) {
            self::REVIEW => 'REVIEW',
            self::APPROVED => 'APPROVED',
            self::REJECTED => 'REJECTED',

            default => 'Tidak Diketahui',
        };
    }
}
