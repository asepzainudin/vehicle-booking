<?php

namespace App\Http\Controllers\Apps\Data;

use App\Http\Controllers\Apps\Controller;
use App\KfnTables\Data\OfficeRegionTable;
use App\KfnTables\Data\VehicleTable;
use App\Models\OfficeRegion;
use App\Models\Vehicle;
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

#[Prefix('vehicle')]
#[Name('vehicle', dotSuffix: true)]
class VehicleController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @param  VehicleTable  $table
     * @param  Request  $request
     *
     * @return View
     */
    // #[Get('', name: 'list', middleware: ['permission:user.show'])]
    #[Get('{vehicle}/list', name: 'list')]
    public function list(VehicleTable $table, Request $request): View
    {
        $table = new VehicleTable();

        $this->setTable($table);
        $this->setPageTitle('Daftar Kendaraan');

        return $this->view('pages.apps.data.vehicle.list');
    }

     /**
     * @param Request $request
     *
     * @return View
     */
    #[Get('create', name: 'create', middleware: ['permission:vehicle.create'])]
    public function create(): View
    {
        $this->setPageTitle("Tambah Kendaraan");

        $this->setBackLink(routed('app.vehicle.list'));
        return $this->view('pages.apps.data.vehicle.form');
    }

    /**
     * @param Request $request
     * @param Vehicle $vehicle
     *
     * @return View
     */
    #[Get('{vehicle}/edit', name: 'edit', middleware: ['permission:vehicle.update'])]
    public function edit(
        Request $request,
        Vehicle $vehicle
    ): View {

        $this->setPageTitle("Kendaraan Detail");
        $this->setBackLink(routed('app.vehicle.list'));

        $this->setData('partner', $vehicle);

        return $this->view('pages.apps.data.vehicle.edit');
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     * @throws \Throwable
     */
    #[Post('', name: 'store', middleware: ['permission:vehicle.create'])]
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required',
            'code' => 'nullable|unique:vehicles,code',
            'type' => 'required|' . Rule::in(['freight_transport', 'people_transport']),
            'status' => 'required|' . Rule::in(['owned', 'rental']),
            'total_vehicles' => 'required',
            'is_active' => 'required',
            'additional.rental_company_name' => 'nullable',
            'additional.rental_company_phone' => 'nullable',
        ]);

        $data['name'] = $validated['name'];
        $data['code'] = $validated['code'];
        $data['type'] = $validated['type'];
        $data['status'] = $validated['status'];
        $data['total_vehicles'] = $validated['total_vehicles'];
        $data['is_active'] = $validated['is_active'] ?? null;
        $data['additional']['rental_company_name'] = $validated['additional']['rental_company_name'] ?? null;
        $data['additional']['rental_company_phone'] = $validated['additional']['rental_company_phone'] ?? null;

        try {
            DB::beginTransaction();

            $vehicle = new Vehicle();

            $vehicle->fill($data);
            $vehicle->save();

            DB::commit();

            flash()->success('Berhasil Menambahkan Kendaraan');
        } catch (\Exception $e) {
            DB::rollBack();

            toSentry($e);
            throw_if(app()->hasDebugModeEnabled(), $e);

            flash()->error('Gagal Menambahkan Kendaraan');

            return back()->withInput();
        }

        return to_route('app.vehicle.list');
    }

    #[Put('{vehicle}', name: 'update', middleware: ['permission:vehicle.update'])]
    public function update(Request $request, Vehicle $vehicle)
    {
        $validated = $request->validate([
            'name' => 'required',
            'code' => [
                    'nullable',
                    Rule::unique('vehicles', 'code')->ignore($vehicle->id),
                ],
            'type' => 'required|' . Rule::in(['freight_transport', 'people_transport']),
            'status' => 'required|' . Rule::in(['owned', 'rental']),
            'total_vehicles' => 'required',
            'is_active' => 'required',
            'additional.rental_company_name' => 'nullable',
            'additional.rental_company_phone' => 'nullable',
        ]);

        $data['name'] = $validated['name'];
        $data['code'] = $validated['code'];
        $data['type'] = $validated['type'];
        $data['status'] = $validated['status'];
        $data['total_vehicles'] = $validated['total_vehicles'];
        $data['is_active'] = $validated['is_active'] ?? null;
        $data['additional']['rental_company_name'] = $validated['additional']['rental_company_name'] ?? null;
        $data['additional']['rental_company_phone'] = $validated['additional']['rental_company_phone'] ?? null;

        try {
            DB::beginTransaction();

            $vehicle->fill($data);
            $vehicle->save();

            DB::commit();

            flash()->success('Berhasil update Kendaraan');
        } catch (\Exception $e) {
            DB::rollBack();

            toSentry($e);
            throw_if(app()->hasDebugModeEnabled(), $e);

            flash()->error('Gagal update Kendaraan');

            return back()->withInput();
        }


        return to_route('app.vehicle.list');
    }

    /**
     * @param Request $request
     * @param Vehicle $vehicle
     *
     * @return View
     */
    #[Get('{vehicle}', name: 'show', middleware: ['permission:vehicle.show'])]
    public function show(
        Request $request,
        Vehicle $vehicle
    ): View {

        $this->setPageTitle("Kendaraan Detail");
        $this->setBackLink(routed('app.vehicle.list'));

        $this->setData('Vehicle', $vehicle);

        return $this->view('pages.apps.data.vehicle.show');
    }

    /**
     * @param Request $request
     * @param Vehicle $vehicle
     *
     * @return View
     */
    #[Delete('{vehicle}', name: 'delete', middleware: ['permission:vehicle.delete'])]
    public function destroy(
        Request $request,
        Vehicle $vehicle
    ): RedirectResponse|JsonResponse {

        $resp = [
            'rc' => 400,
            'success' => false,
            'message' => 'failed',
        ];
        
        if ($vehicle->vechicleOrders()->exists()) {
            $resp['message'] = 'Kendaraan tidak bisa dihapus, karena sudah ada pemesanan kendaraan terkait.';
            if ($request->ajax()) {
                return response()->json($resp, $resp['rc']);
            }
            flash()->error($resp['message']);
            return back();
        }

        try {
            $vehicle->delete();

            $resp['rc'] = 200;
            $resp['success'] = true;
            $resp['message'] = 'Kendaraan berhasil di hapus';
        } catch (Exception $e) {
            toSentry($e);

            $resp['message'] = 'Kendaraan gagal di hapus';
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
     *
     * @return JsonResponse
     */
    #[Get('vehicle-search/search', name: 'vehicle-search.search', middleware: ['permission:vehicle.show'])]
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