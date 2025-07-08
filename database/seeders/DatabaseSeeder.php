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
            SeedDefaultConfig::class,

            // SeedGeo::class,
            SeedRbac::class,
            SeedPermission::class,
            SeedAirline::class,
            SeedTravel::class,
            SeedUser::class,
        ]);
    }
}
