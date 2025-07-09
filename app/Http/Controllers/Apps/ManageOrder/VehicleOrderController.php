<?php

namespace App\Http\Controllers\Apps\ManageOrder;

use App\Enums\StatusType;
use App\Http\Controllers\Apps\Controller;
use App\KfnTables\ManageOrder\VehicleOrderTable;
use App\Models\Vehicle;
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
use Illuminate\Validation\Rule;

#[Prefix('vehicle-order')]
#[Name('vehicle-order', dotSuffix: true)]
class VehicleOrderController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @param  VehicleOrderTable  $table
     * @param  Request  $request
     *
     * @return View
     */
    // #[Get('', name: 'list', middleware: ['permission:user.show'])]
    #[Get('', name: 'list')]
    public function list(VehicleOrderTable $table, Request $request): View
    {
        $table = new VehicleOrderTable();

        $this->setTable($table);
        $this->setPageTitle('Daftar Pemesanan Kendaraan');

        return $this->view('pages.apps.manage-order.order.list');
    }

     /**
     * @param Request $request
     *
     * @return View
     */
    #[Get('create', name: 'create', middleware: ['permission:vehicle-order.create'])]
    public function create(): View
    {
        $this->setPageTitle("Tambah Pemesanan Kendaraan");

        $this->setBackLink(routed('app.vehicle-order.list'));
        return $this->view('pages.apps.manage-order.order.form');
    }

    /**
     * @param Request $request
     * @param VehicleOrder $vehicleOrder
     *
     * @return View
     */
    #[Get('{vehicleOrder}/edit', name: 'edit', middleware: ['permission:vehicle-order.update'])]
    public function edit(
        Request $request,
        VehicleOrder $vehicleOrder
    ): View {

        $this->setPageTitle("Pemesanan Kendaraan Detail");
        $this->setBackLink(routed('app.vehicle-order.list'));

        $this->setData('vehicleOrder', $vehicleOrder);

        return $this->view('pages.apps.manage-order.order.edit');
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     * @throws \Throwable
     */
    #[Post('', name: 'store', middleware: ['permission:vehicle-order.create'])]
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'code' => 'required',
            'vehicle_id' => 'required',
            'mine_location_id' => 'nullable',
            'driver_id' => 'required',
            'reviewer_id' => 'required',
            'approver_id' => 'required',
        ]);

        $data['code'] = $validated['code'];
        $data['vehicle_id'] = $validated['vehicle_id'];
        $data['mine_location_id'] = $validated['mine_location_id'] ?? null;
        $data['driver_id'] = $validated['driver_id'];
        $data['reviewer_id'] = $validated['reviewer_id'];
        $data['approver_id'] = $validated['approver_id'];
        $data['created_by'] = auth()->user()->id;

        try {
            DB::beginTransaction();

            $vehicle = new VehicleOrder();

            $vehicle->fill($data);
            $vehicle->save();

            DB::commit();

            flash()->success('Berhasil Menambahkan Pemesanan Kendaraan');
        } catch (\Exception $e) {
            DB::rollBack();

            toSentry($e);
            throw_if(app()->hasDebugModeEnabled(), $e);

            flash()->error('Gagal Menambahkan Pemesanan Kendaraan');

            return back()->withInput();
        }

        return to_route('app.vehicle-order.list');
    }

    #[Put('{vehicleOrder}', name: 'update', middleware: ['permission:vehicle-order.update'])]
    public function update(Request $request, VehicleOrder $vehicleOrder)
    {
       $validated = $request->validate([
            'code' => [
                    'required',
                    Rule::unique('vehicle_orders', 'code')->ignore($vehicleOrder->id),
                ],
            'vehicle_id' => 'required',
            'mine_location_id' => 'nullable',
            'driver_id' => 'required',
            'reviewer_id' => 'required',
            'approver_id' => 'required',
        ]);

        $data['code'] = $validated['code'];
        $data['vehicle_id'] = $validated['vehicle_id'];
        $data['mine_location_id'] = $validated['mine_location_id'] ?? null;
        $data['driver_id'] = $validated['driver_id'];
        $data['reviewer_id'] = $validated['reviewer_id'];
        $data['approver_id'] = $validated['approver_id'];
        $data['updated_by'] = auth()->user()->id;

        try {
            DB::beginTransaction();

            $vehicleOrder->fill($data);
            $vehicleOrder->save();

            DB::commit();

            flash()->success('Berhasil update Pemesanan Kendaraan');
        } catch (\Exception $e) {
            DB::rollBack();

            toSentry($e);
            throw_if(app()->hasDebugModeEnabled(), $e);

            flash()->error('Gagal update Pemesanan Kendaraan');

            return back()->withInput();
        }


        return to_route('app.vehicle-order.list');
    }

    /**
     * @param Request $request
     * @param VehicleOrder $vehicleOrder
     *
     * @return View
     */
    #[Get('{vehicleOrder}', name: 'show', middleware: ['permission:vehicle-order.show'])]
    public function show(
        Request $request,
        VehicleOrder $vehicleOrder
    ): View {
        $this->setPageTitle("Pemesanan Kendaraan Detail");
        $this->setBackLink(routed('app.vehicle-order.list'));

        $this->setData('vehicleOrder', $vehicleOrder);

        return $this->view('pages.apps.manage-order.order.show');
    }

    /**
     * @param Request $request
     * @param VehicleOrder $vehicleOrder
     *
     * @return View
     */
    #[Delete('{vehicleOrder}', name: 'delete', middleware: ['permission:vehicle-order.delete'])]
    public function destroy(
        Request $request,
        VehicleOrder $vehicleOrder
    ): RedirectResponse|JsonResponse {

        $resp = [
            'rc' => 400,
            'success' => false,
            'message' => 'failed',
        ];

        try {
            $vehicleOrder->delete();

            $resp['rc'] = 200;
            $resp['success'] = true;
            $resp['message'] = 'Pemesanan Kendaraan berhasil di hapus';
        } catch (Exception $e) {
            toSentry($e);

            $resp['message'] = 'Pemesanan Kendaraan gagal di hapus';
            if (app()->hasDebugModeEnabled()) {
                $resp['message'] .= '<br><br>' . $e->getMessage();
            }
        }

        if ($request->ajax()) {
            return response()->json($resp, $resp['rc']);
        }

        return back();
    }

    /**
     * @param Request $request
     * @param VehicleOrder $vehicleOrder
     *
     */
    #[Get('{vehicleOrder}/{status}', name: 'status', middleware: ['permission:vehicle-order.status'])]
    public function status(
        Request $request,
        VehicleOrder $vehicleOrder,
        $status
    ) {
        if ($status == 'approved') {

            $vehicleOrder->statusHistories()->create([
                'from_status' => $vehicleOrder->status->value,
                'to_status' => StatusType::APPROVED->value,
                'note' => $request->input('reason', ''),
                'changed_by' => auth()->user()->id,
            ]);

            $vehicleOrder->status = StatusType::APPROVED->value;
        }

        if ($status == 'review') {

           $vehicleOrder->statusHistories()->create([
                'from_status' => $vehicleOrder->status->value,
                'to_status' => StatusType::REVIEW->value,
                'note' => $request->input('reason', ''),
                'changed_by' => auth()->user()->id,
            ]);

            $vehicleOrder->status = StatusType::REVIEW->value;
        }

        if ($status == 'rejected') {
             $vehicleOrder->statusHistories()->create([
                'from_status' => $vehicleOrder->status->value,
                'to_status' => StatusType::REJECTED->value,
                'note' => $request->input('reason', ''),
                'changed_by' => auth()->user()->id,
            ]);

            $vehicleOrder->status = StatusType::REJECTED->value;
        }

        
        if ($status == 'return') {
             $vehicleOrder->statusHistories()->create([
                'from_status' => $vehicleOrder->status->value,
                'to_status' => StatusType::RETURN->value,
                'note' => $request->input('reason', ''),
                'changed_by' => auth()->user()->id,
            ]);

            $vehicleOrder->status = StatusType::REJECTED->value;
        }

        $vehicleOrder->save();

        return back()->withInput();
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    #[Get('vehicle-search/search', name: 'vehicle-search.search', middleware: ['permission:vehicle-order.show'])]
    public function search(Request $request)
    {
        $search = $request->input('search', '');
        $query = Vehicle::query()
            ->where('is_active', true)
            ->where(function ($q) use ($search) {
                $q->where('name', 'ilike', "%{$search}%")
                    ->orWhere('code', 'ilike', "%{$search}%");
            });
      
        return response()->json($query->get());
    }
}