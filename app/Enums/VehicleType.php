<?php

namespace App\Enums;

enum VehicleType: string
{
    case FREIGHTTRANSPORT = 'freight_transport';
    case PEOPLETRANSPORT = 'people_transport';

    public function label(): string
    {
        return match ($this) {
            self::FREIGHTTRANSPORT => 'Angkutan Barang',
            self::PEOPLETRANSPORT => 'Angkutan Orang',

            default => 'Tidak Diketahui',
        };
    }
}
