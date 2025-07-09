<?php

namespace Database\Seeders;

use App\Models\OfficeRegion;
use Illuminate\Database\Seeder;

class SeedOfficeRegion extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ($this->officeRegionData() as $office) {
            OfficeRegion::query()->create($office);
        }
    }

    private function officeRegionData(): array
    {
        return [
            [
                'name' => 'Kantor Cabang Riau',
                'code' => 'KCR-01',
            ],
        ];
    }
}
