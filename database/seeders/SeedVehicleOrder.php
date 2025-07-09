<?php

namespace Database\Seeders;

use App\Enums\StatusType;
use App\Enums\UserType;
use App\Enums\VehicleType;
use App\Models\Mine;
use App\Models\User;
use App\Models\Vehicle;
use App\Models\VehicleOrder;
use Illuminate\Database\Seeder;

class SeedVehicleOrder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $vehicle = Vehicle::query()->get();

        foreach($vehicle as $v){
            foreach ($this->vehicleOrderData() as $order) {
                $mine = Mine::inRandomOrder()->first();
                $driver = User::where('type', UserType::DRIVER)->inRandomOrder()->first();
                $reviewer = User::where('type', UserType::STAFF)
                            ->whereHas('roles', function ($query) {
                                $query->whereIn('name', ['reviewer']);
                            })->inRandomOrder()->first();
                $approval = User::where('type', UserType::STAFF)
                            ->whereHas('roles', function ($query) {
                                $query->whereIn('name', ['approval']);
                            })->inRandomOrder()->first();

                $order['vehicle_id'] = $v->id;
                $order['mine_location_id'] = $mine->id;
                $order['driver_id'] = $driver->id;
                $order['reviewer_id'] = $reviewer->id;
                $order['approver_id'] = $approval->id;
                if ($v->type == VehicleType::FREIGHTTRANSPORT->value) {
                    $order['additional'] = [
                        'rental_company' => $v->additional['rental_company'] ?? 'Default Rental Company',
                        'rental_phone' => $v->additional['rental_phone'] ?? '+62123456789',
                    ];
                }
                
                $data = [
                    'total_vehicles' => $v->total_vehicles - 1,
                ];

                $v->update($data);

                VehicleOrder::query()->create($order);
            }
        }
    }
   
    private function vehicleOrderData(): array
    {
        return [
            [
                'status' =>  StatusType::REVIEW,
            ],
            [
                'status' =>  StatusType::REVIEW,
            ],
        ];
    }
}
