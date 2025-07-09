<?php

namespace App\Http\Controllers\Apps\ManageOrder;

use App\Http\Controllers\Apps\Controller;
use App\KfnTables\Data\VehicleTable;
use App\KfnTables\ManageOrder\VehicleUsageTable;
use App\Models\VehicleOrder;
use App\Models\VehicleUsage;
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
use Illuminate\Validation\Rule;

#[Prefix('vehicle-usage')]
#[Name('vehicle-usage', dotSuffix: true)]
class VehicleUsageController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @param  VehicleOrder  $vehicleOrder
     * @param  VehicleUsageTable  $table
     * @param  Request  $request
     *
     * @return View
     */
    // #[Get('', name: 'list', middleware: ['permission:user.show'])]
    #[Get('{vehicleOrder}/list', name: 'list')]
    public function list(VehicleOrder $vehicleOrder, VehicleUsageTable $table, Request $request): View
    {
        $table = new VehicleUsageTable($vehicleOrder);

        $this->setTable($table);
        $this->setPageTitle('Riwayat Pemakaian ' . ($vehicleOrder->vehicle?->name ? $vehicleOrder->vehicle->name . '-' . $vehicleOrder->code : ''));
        $this->setData('vehicleOrder', $vehicleOrder);

        return $this->view('pages.apps.manage-order.usage.list');
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
        $this->setPageTitle('Riwayat Pemakaian ' . ($vehicleOrder->vehicle?->name ? $vehicleOrder->vehicle->name . '-' . $vehicleOrder->code : ''));

        $this->setBackLink(routed('app.vehicle-usage.list', $vehicleOrder->hash_id));
        return $this->view('pages.apps.manage-order.usage.form');
    }

    /**
     * @param Request $request
     * @param VehicleUsage $vehicleUsage
     *
     * @return View
     */
    #[Get('{vehicleUsage}/edit', name: 'edit')]
    public function edit(
        Request $request,
        VehicleUsage $vehicleUsage
    ): View {

        $this->setPageTitle('Riwayat Pemakaian ' . ($vehicleUsage->vehicle?->name ? $vehicleUsage->vehicle->name . '-' . $vehicleUsage->code : ''));
        $this->setBackLink(routed('app.vehicle.list'));

        $this->setData('vehicleUsage', $vehicleUsage);

        return $this->view('pages.apps.manage-order.usage.edit');
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
            'date_use' => 'required',
            'additional.noted' => 'required',
        ]);

        $data['vehicle_id'] = $vehicleOrder->vehicle->id;
        $data['vehicle_order_id'] = $vehicleOrder->id;
        $data['date_use'] = $validated['date_use'];
        $data['additional']['noted'] = $validated['additional']['noted'] ?? null;

        try {
            DB::beginTransaction();

            $vehicle = new VehicleUsage();

            $vehicle->fill($data);
            $vehicle->save();

            DB::commit();

            flash()->success('Berhasil Menambahkan Riwayat Pemakaian');
        } catch (\Exception $e) {
            DB::rollBack();

            toSentry($e);
            throw_if(app()->hasDebugModeEnabled(), $e);

            flash()->error('Gagal Menambahkan Riwayat Pemakaian');

            return back()->withInput();
        }

        return to_route('app.vehicle-usage.list', $vehicleOrder->hash_id);
    }

    #[Put('{vehicleUsage}', name: 'update')]
    public function update(Request $request, VehicleUsage $vehicleUsage)
    {
        $validated = $request->validate([
            'date_use' => 'required',
            'additional.noted' => 'required',
        ]);

        $data['date_use'] = $validated['date_use'];
        $data['additional']['noted'] = $validated['additional']['noted'] ?? null;

        try {
            DB::beginTransaction();

            $vehicleUsage->fill($data);
            $vehicleUsage->save();

            DB::commit();

            flash()->success('Berhasil update Riwayat Pemakaian');
        } catch (\Exception $e) {
            DB::rollBack();

            toSentry($e);
            throw_if(app()->hasDebugModeEnabled(), $e);

            flash()->error('Gagal update Riwayat Pemakaian');

            return back()->withInput();
        }

        return to_route('app.vehicle-usage.list', $vehicleUsage->vehicleOrder->hash_id);
    }

    /**
     * @param Request $request
     * @param VehicleUsage $vehicleUsage
     *
     * @return View
     */
    #[Get('{vehicleUsage}', name: 'show')]
    public function show(
        Request $request,
        VehicleUsage $vehicleUsage
    ): View {

        $this->setPageTitle("Riwayat Pemakaian Detail");
        $this->setBackLink(routed('app.vehicle.list'));

        $this->setData('vehicleUsage', $vehicleUsage);

        return $this->view('pages.apps.manage-order.usage.show');
    }

    /**
     * @param Request $request
     * @param VehicleUsage $vehicleUsage
     *
     * @return View
     */
    #[Delete('{vehicleUsage}', name: 'delete')]
    public function destroy(
        Request $request,
        VehicleUsage $vehicleUsage
    ): RedirectResponse|JsonResponse {

        $resp = [
            'rc' => 400,
            'success' => false,
            'message' => 'failed',
        ];
     
        try {
            $vehicleUsage->delete();

            $resp['rc'] = 200;
            $resp['success'] = true;
            $resp['message'] = 'Riwayat Pemakaian berhasil di hapus';
        } catch (Exception $e) {
            toSentry($e);

            $resp['message'] = 'Riwayat Pemakaian gagal di hapus';
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