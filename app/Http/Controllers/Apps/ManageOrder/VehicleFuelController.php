<?php

namespace App\Http\Controllers\Apps\ManageOrder;

use App\Http\Controllers\Apps\Controller;
use App\KfnTables\ManageOrder\VehicleFuelTable;
use App\Models\VehicleFuel;
use App\Models\VehicleOrder;
use Dentro\Yalr\Attributes\Delete;
use Dentro\Yalr\Attributes\Get;
use Dentro\Yalr\Attributes\Name;
use Dentro\Yalr\Attributes\Post;
use Dentro\Yalr\Attributes\Prefix;
use Dentro\Yalr\Attributes\Put;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

#[Prefix('vehicle-fuel')]
#[Name('vehicle-fuel', dotSuffix: true)]
class VehicleFuelController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @param  VehicleOrder  $vehicleOrder
     * @param  VehicleFuelTable  $table
     * @param  Request  $request
     *
     * @return View
     */
    // #[Get('', name: 'list', middleware: ['permission:user.show'])]
    #[Get('{vehicleOrder}/list', name: 'list')]
    public function list(VehicleOrder $vehicleOrder, VehicleFuelTable $table, Request $request): View
    {
        $table = new VehicleFuelTable($vehicleOrder);

        $this->setTable($table);
        $this->setPageTitle('Konsumsi BBM ' . ($vehicleOrder->vehicle?->name ? $vehicleOrder->vehicle->name . '-' . $vehicleOrder->code : ''));
        $this->setData('vehicleOrder', $vehicleOrder);

        return $this->view('pages.apps.manage-order.fuel.list');
    }

     /**
     * @param  VehicleOrder  $vehicleOrder
     * @param Request $request
     *
     * @return View
     */
    #[Get('{vehicleOrder}/create', name: 'create')]
    public function create(VehicleOrder $vehicleOrder): View
    {
        $this->setPageTitle('Konsumsi BBM ' . ($vehicleOrder->vehicle?->name ? $vehicleOrder->vehicle->name . '-' . $vehicleOrder->code : ''));

        $this->setBackLink(routed('app.vehicle-fuel.list', $vehicleOrder->hash_id));
        return $this->view('pages.apps.manage-order.fuel.form');
    }

    /**
     * @param Request $request
     * @param VehicleFuel $vehicleFuel
     *
     * @return View
     */
    #[Get('{vehicleFuel}/edit', name: 'edit')]
    public function edit(
        Request $request,
        VehicleFuel $vehicleFuel
    ): View {

        $this->setPageTitle('Konsumsi BBM ' . ($vehicleFuel->vehicle?->name ? $vehicleFuel->vehicle->name . '-' . $vehicleFuel->code : ''));
        $this->setBackLink(routed('app.vehicle.list'));

        $this->setData('vehicleFuel', $vehicleFuel);

        return $this->view('pages.apps.manage-order.fuel.edit');
    }

    /**
     * @param  VehicleOrder $vehicleOrder
     * @param Request $request
     * @return RedirectResponse
     * @throws \Throwable
     */
    #[Post('{vehicleOrder}/store', name: 'store')]
    public function store(VehicleOrder $vehicleOrder, Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'date_fuel_consumption' => 'required',
            'fuel_consumption' => 'nullable',
            'fuel_cost' => 'nullable',
            'fuel_type' => 'nullable',
            'additional.noted' => 'required',
        ]);

        $data['vehicle_id'] = $vehicleOrder->vehicle->id;
        $data['vehicle_order_id'] = $vehicleOrder->id;
        $data['date_fuel_consumption'] = $validated['date_fuel_consumption'] ?? null;
        $data['fuel_consumption'] = $validated['fuel_consumption'] ?? null;
        $data['fuel_cost'] = $validated['fuel_cost'] ?? null;
        $data['fuel_type'] = $validated['fuel_type'] ?? null;
        $data['additional']['noted'] = $validated['additional']['noted'] ?? null;
        
        try {
            DB::beginTransaction();

            $vehicle = new VehicleFuel();

            $vehicle->fill($data);
            $vehicle->save();

            DB::commit();

            flash()->success('Berhasil Menambahkan Konsumsi BBM');
        } catch (\Exception $e) {
            DB::rollBack();

            toSentry($e);
            throw_if(app()->hasDebugModeEnabled(), $e);

            flash()->error('Gagal Menambahkan Konsumsi BBM');

            return back()->withInput();
        }

        return to_route('app.vehicle-fuel.list', $vehicleOrder->hash_id);
    }

    #[Put('{vehicleFuel}', name: 'update')]
    public function update(Request $request, VehicleFuel $vehicleFuel)
    {
          $validated = $request->validate([
            'date_fuel_consumption' => 'required',
            'fuel_consumption' => 'nullable',
            'fuel_cost' => 'nullable',
            'fuel_type' => 'nullable',
            'additional.noted' => 'required',
        ]);

        $data['vehicle_id'] = $vehicleFuel->vehicle->id;
        $data['vehicle_order_id'] = $vehicleFuel->id;
        $data['date_fuel_consumption'] = $validated['date_fuel_consumption'] ?? null;
        $data['fuel_consumption'] = $validated['fuel_consumption'] ?? null;
        $data['fuel_cost'] = $validated['fuel_cost'] ?? null;
        $data['fuel_type'] = $validated['fuel_type'] ?? null;
        $data['additional']['noted'] = $validated['additional']['noted'] ?? null;

        try {
            DB::beginTransaction();

            $vehicleFuel->fill($data);
            $vehicleFuel->save();

            DB::commit();

            flash()->success('Berhasil update Konsumsi BBM');
        } catch (\Exception $e) {
            DB::rollBack();

            toSentry($e);
            throw_if(app()->hasDebugModeEnabled(), $e);

            flash()->error('Gagal update Konsumsi BBM');

            return back()->withInput();
        }

        return to_route('app.vehicle-fuel.list', $vehicleFuel->vehicleOrder->hash_id);
    }

    /**
     * @param Request $request
     * @param VehicleFuel $vehicleFuel
     *
     * @return View
     */
    #[Get('{vehicleFuel}', name: 'show')]
    public function show(
        Request $request,
        VehicleFuel $vehicleFuel
    ): View {

        $this->setPageTitle("Konsumsi BBM Detail");
        $this->setBackLink(routed('app.vehicle.list'));

        $this->setData('vehicleFuel', $vehicleFuel);

        return $this->view('pages.apps.manage-order.fuel.show');
    }

    /**
     * @param Request $request
     * @param VehicleFuel $vehicleFuel
     *
     * @return View
     */
    #[Delete('{vehicleFuel}', name: 'delete')]
    public function destroy(
        Request $request,
        VehicleFuel $vehicleFuel
    ): RedirectResponse|JsonResponse {

        $resp = [
            'rc' => 400,
            'success' => false,
            'message' => 'failed',
        ];
     
        try {
            $vehicleFuel->delete();

            $resp['rc'] = 200;
            $resp['success'] = true;
            $resp['message'] = 'Konsumsi BBM berhasil di hapus';
        } catch (Exception $e) {
            toSentry($e);

            $resp['message'] = 'Konsumsi BBM gagal di hapus';
            if (app()->hasDebugModeEnabled()) {
                $resp['message'] .= '<br><br>' . $e->getMessage();
            }
        }

        if ($request->ajax()) {
            return response()->json($resp, $resp['rc']);
        }

        return back();
    }
}