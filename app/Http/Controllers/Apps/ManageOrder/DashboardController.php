<?php

namespace App\Http\Controllers\Apps\ManageOrder;

use App\Enums\StatusType;
use App\Http\Controllers\Apps\Controller;
use App\Models\VehicleOrder;
use Dentro\Yalr\Attributes\Get;
use Dentro\Yalr\Attributes\Name;
use Dentro\Yalr\Attributes\Prefix;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

#[Prefix('vehicle-dashboard')]
#[Name('vehicle-dashboard', dotSuffix: true)]
class DashboardController extends Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @param Request $request
     *
     * @throws \Throwable
     * @return View
     */
    #[Get('', name: 'dashboard')]
    public function dashboard(Request $request): View
    {
        $this->setPageTitle('Dashboard');

        $dataStatusPemakaian = VehicleOrder::join('vehicles', 'vehicle_orders.vehicle_id', '=', 'vehicles.id')
            ->select(
                'vehicles.name as kendaraan',
                'vehicle_orders.status',
                DB::raw('count(*) as total')
            )
            ->groupBy('vehicles.name', 'vehicle_orders.status')
            ->where(function($query){
                $query->where('vehicle_orders.status', StatusType::APPROVED)
                    ->orWhere('vehicle_orders.status', StatusType::RETURN);
            })
            ->get();

        $stsPemakaian = collect();
        foreach ($dataStatusPemakaian as $key => $value) {
            $stsPemakaian->push(
                [
                    'kendaraan_slug' => Str::slug($value->kendaraan),
                    'kendaraan' => $value->kendaraan,
                    'total' => $value->total,
                ]
            );
        }
   
        $this->setData('stsPemakaian', $stsPemakaian);

        return $this->view('pages.apps.manage-order.dashboard');
    }
}