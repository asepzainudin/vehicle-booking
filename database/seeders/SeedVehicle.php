<?php

namespace Database\Seeders;

use App\Enums\VehicleType;
use App\Models\OfficeRegion;
use App\Models\Vehicle;
use Illuminate\Database\Seeder;

class SeedVehicle extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ($this->officeRegionData() as $office) {
            Vehicle::query()->create($office);
        }
    }

    private function officeRegionData(): array
    {
        return [
            [
                'code' => 'truck',
                'name' => 'TRUCK',
                'type' => VehicleType::FREIGHTTRANSPORT,
                'status' => 'owned',
                'value' => 'Truck',
                'additional' => [
                    'rental_company' => 'PT. Rental Indonesia',
                    'rental_phone' => '+62123456789',
                ],
                'total_vehicles' => 10,
                'is_active' => true,
            ],
             [
                'code' => 'truck-rent',
                'name' => 'TRUCK RENTAL',
                'type' => VehicleType::FREIGHTTRANSPORT,
                'status' => 'rental',
                'value' => 'Truck Rental',
                'additional' => [
                    'rental_company' => 'PT. Rental Indonesia',
                    'rental_phone' => '+62123456789',
                    'start_date' => '2024-01-01',
                    'end_date' => '2025-12-31',
                ],
                'total_vehicles' => 10,
                'is_active' => true,
            ],
        ];
    }
}
