<?php

namespace Database\Seeders;

use App\Models\Partner\Partner;
use App\Models\Travel\Travel;
use App\Models\User;
use Illuminate\Database\Seeder;

class SeedTravel extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $partner = Partner::query()->first();
        $user = User::query()
            ->select('id')
            ->where('partner_id', $partner->id)
            ->first();

        foreach ($this->data() as $item) {
             $item = array_merge([
                    'partner_id' => $partner->id,
                    'created_by' => $user?->id,
                ], $item);

            Travel::query()->create($item);
        }
    }

    private function data(): array
    {
        return [
            [
                'name' => 'PT. Hasanah Tours & Travel',
                'code' => 'HTT',
                'phone' => '021-12345678',
            ],
            [
                'name' => 'PT. Almira Travel',
                'code' => 'AT',
                'phone' => '021-87654321',
            ],
            [
                'name' => 'PT. Hijaz Biqolbu Umroh',
                'code' => 'HBU',
                'phone' => '021-11223344',
            ],
        ];
    }
}
