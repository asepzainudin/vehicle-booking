<?php

namespace Database\Seeders;

use App\Models\Partner\Airline;
use Illuminate\Database\Seeder;

class SeedAirline extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ($this->airlineData() as $masjid) {
            Airline::query()->create($masjid);
        }
    }

    private function airlineData(): array
    {
        return [
            [
                'name' => 'Garuda',
                'code' => 'garuda',
            ],
            [
                'name' => 'Saudi Airlines',
                'code' => 'saudi-airlines',
            ],
        ];
    }
}
