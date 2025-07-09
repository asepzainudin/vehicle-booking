<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            // SeedGeo::class,
            SeedRbac::class,
            SeedPermission::class,
            SeedUser::class,
            SeedOfficeRegion::class,
            SeedMineLocation::class,
            SeedVehicle::class,
            SeedVehicleOrder::class,
        ]);
    }
}
