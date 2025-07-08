<?php

namespace App\Enums\Dataset;

enum ContactType: string
{
    case RESIDENT = 'resident';
    case NON_RESIDENT = 'non_resident';

    public function label(): string
    {
        return match ($this) {
            self::RESIDENT => 'Penduduk',
            self::NON_RESIDENT => 'Bukan Penduduk',

            default => 'Tidak Diketahui',
        };
    }
}
