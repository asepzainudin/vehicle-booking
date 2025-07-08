<?php

namespace App\Enums;

enum StatusType: string
{
    case REVIEW = 'review';
    case APPROVED = 'approved';
    case REJECTED = 'rejected';
    case SENDBACK = 'sendback';

    public function label(): string
    {
        return match ($this) {
            self::REVIEW => 'REVIEW',
            self::APPROVED => 'APPROVED',
            self::REJECTED => 'REJECTED',
            self::SENDBACK => 'SENDBACK',

            default => 'Tidak Diketahui',
        };
    }
}
