<?php

namespace Database\Seeders;

use App\Models\Mine;
use Illuminate\Database\Seeder;

class SeedMine extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ($this->mineLocationData() as $order) {
            Mine::query()->create($order);
        }
    }
  
    private function mineLocationData(): array
    {
        return [
            [
                'office_region_id' => 1, // Assuming the first office region is Riau
                'code' => 'trb',
                'name' => 'Tambang Riau barat',
                'additional' => [
                    'address' => 'Jl. Tambang Barat No.1, Pekanbaru, Riau',
                ],
            ],
            [
                'office_region_id' => 1, // Assuming the first office region is Riau
                'code' => 'trt',
                'name' => 'Tambang Riau Timur',
                'additional' => [
                    'address' => 'Jl. Tambang Timur No.2, Pekanbaru, Riau',
                ],
            ],
        ];
    }
}
