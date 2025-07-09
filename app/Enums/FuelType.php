<?php

namespace App\Enums;

enum FuelType: string
{
    case PERTALITE = 'pertalite';
    case PERTAMAX = 'pertamax';
    case PERTAMAXTURBO = 'pertamax_turbo';
    case SOLAR = 'solar';

    public function label(): string
    {
        return match ($this) {
            self::PERTALITE => 'Pertalite',
            self::PERTAMAX => 'Pertamax',
            self::PERTAMAXTURBO => 'Pertamax Turbo',
            self::SOLAR => 'Solar',

            default => 'Tidak Diketahui',
        };
    }
}