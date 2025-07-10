<?php

namespace App\Http\Controllers\Apps\ManageOrder;

use App\Http\Controllers\Apps\Controller;
use App\KfnTables\ManageOrder\VehicleServiceTable;
use App\Models\VehicleService;
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

#[Prefix('vehicle-service')]
#[Name('vehicle-service', dotSuffix: true)]
class VehicleServiceController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @param  VehicleOrder  $vehicleOrder
     * @param  VehicleServiceTable  $table
     * @param  Request  $request
     *
     * @return View
     */
    // #[Get('', name: 'list', middleware: ['permission:user.show'])]
    #[Get('{vehicleOrder}/list', name: 'list')]
    public function list(VehicleOrder $vehicleOrder, VehicleServiceTable $table, Request $request): View
    {
        $table = new VehicleServiceTable($vehicleOrder);

        $this->setTable($table);
        $this->setPageTitle('Jadwal Service ' . ($vehicleOrder->vehicle?->name ? $vehicleOrder->vehicle->name . '-' . $vehicleOrder->code : ''));
        $this->setData('vehicleOrder', $vehicleOrder);

        return $this->view('pages.apps.manage-order.service.list');
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
        $this->setPageTitle('Jadwal Service ' . ($vehicleOrder->vehicle?->name ? $vehicleOrder->vehicle->name . '-' . $vehicleOrder->code : ''));

        $this->setBackLink(routed('app.vehicle-service.list', $vehicleOrder->hash_id));
        return $this->view('pages.apps.manage-order.service.form');
    }

    /**
     * @param Request $request
     * @param VehicleService $vehicleService
     *
     * @return View
     */
    #[Get('{vehicleService}/edit', name: 'edit')]
    public function edit(
        Request $request,
        VehicleService $vehicleService
    ): View {

        $this->setPageTitle('Jadwal Service ' . ($vehicleService->vehicle?->name ? $vehicleService->vehicle->name . '-' . $vehicleService->code : ''));
        $this->setBackLink(routed('app.vehicle.list'));

        $this->setData('vehicleService', $vehicleService);

        return $this->view('pages.apps.manage-order.service.edit');
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
            'date_service' => 'required',
            'service_cost' => 'nullable',
            'additional.noted' => 'required',
        ]);

        $data['vehicle_id'] = $vehicleOrder->vehicle->id;
        $data['vehicle_order_id'] = $vehicleOrder->id;
        $data['date_service'] = $validated['date_service'];
        $data['service_cost'] = $validated['service_cost'];
        $data['additional']['noted'] = $validated['additional']['noted'] ?? null;

        try {
            DB::beginTransaction();

            $vehicle = new VehicleService();

            $vehicle->fill($data);
            $vehicle->save();

            DB::commit();

            flash()->success('Berhasil Menambahkan Jadwal Service');
        } catch (\Exception $e) {
            DB::rollBack();

            toSentry($e);
            throw_if(app()->hasDebugModeEnabled(), $e);

            flash()->error('Gagal Menambahkan Jadwal Service');

            return back()->withInput();
        }

        return to_route('app.vehicle-service.list', $vehicleOrder->hash_id);
    }

    #[Put('{vehicleService}', name: 'update')]
    public function update(Request $request, VehicleService $vehicleService)
    {
        $validated = $request->validate([
            'date_service' => 'required',
            'service_cost' => 'nullable',
            'additional.noted' => 'required',
        ]);

        $data['date_service'] = $validated['date_service'];
        $data['service_cost'] = $validated['service_cost'];
        $data['additional']['noted'] = $validated['additional']['noted'] ?? null;

        try {
            DB::beginTransaction();

            $vehicleService->fill($data);
            $vehicleService->save();

            DB::commit();

            flash()->success('Berhasil update Jadwal Service');
        } catch (\Exception $e) {
            DB::rollBack();

            toSentry($e);
            throw_if(app()->hasDebugModeEnabled(), $e);

            flash()->error('Gagal update Jadwal Service');

            return back()->withInput();
        }

        return to_route('app.vehicle-service.list', $vehicleService->vehicleOrder->hash_id);
    }

    /**
     * @param Request $request
     * @param VehicleService $vehicleService
     *
     * @return View
     */
    #[Get('{vehicleService}', name: 'show')]
    public function show(
        Request $request,
        VehicleService $vehicleService
    ): View {

        $this->setPageTitle("Jadwal Service Detail");
        $this->setBackLink(routed('app.vehicle.list'));

        $this->setData('vehicleService', $vehicleService);

        return $this->view('pages.apps.manage-order.service.show');
    }

    /**
     * @param Request $request
     * @param VehicleService $vehicleService
     *
     * @return View
     */
    #[Delete('{vehicleService}', name: 'delete')]
    public function destroy(
        Request $request,
        VehicleService $vehicleService
    ): RedirectResponse|JsonResponse {

        $resp = [
            'rc' => 400,
            'success' => false,
            'message' => 'failed',
        ];
     
        try {
            $vehicleService->delete();

            $resp['rc'] = 200;
            $resp['success'] = true;
            $resp['message'] = 'Jadwal Service berhasil di hapus';
        } catch (Exception $e) {
            toSentry($e);

            $resp['message'] = 'Jadwal Service gagal di hapus';
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