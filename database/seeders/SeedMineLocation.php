<?php

namespace Database\Seeders;

use App\Models\MineLocation;
use Illuminate\Database\Seeder;

class SeedMineLocation extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ($this->mineLocationData() as $order) {
            MineLocation::query()->create($order);
        }
    }
  
    private function mineLocationData(): array
    {
        return [
            [
                'office_region_id' => 1, // Assuming the first office region is Riau
                'code' => 'trb',
                'name' => 'Tambang Riau barat'
            ],
            [
                'office_region_id' => 1, // Assuming the first office region is Riau
                'code' => 'trt',
                'name' => 'Tambang Riau Timur',
            ],
        ];
    }
}
