<?php

namespace App\Enums;

enum VehicleType: string
{
    case PEOPLETRANSPORT = 'people_transport';
    case FREIGHTTRANSPORT = 'freight_transport';

    public function label(): string
    {
        return match ($this) {
            self::PEOPLETRANSPORT => 'Angkutan Orang',
            self::FREIGHTTRANSPORT => 'Angkutan Barang',

            default => 'Tidak Diketahui',
        };
    }
}
