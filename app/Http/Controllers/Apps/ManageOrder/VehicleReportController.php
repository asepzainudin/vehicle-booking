<?php

namespace App\Http\Controllers\Apps\ManageOrder;

use App\Exports\ExportFuel;
use App\Exports\ExportService;
use App\Exports\ExportUsage;
use App\Http\Controllers\Apps\Controller;
use App\KfnTables\Data\OfficeRegionTable;
use App\KfnTables\ManageOrder\VehicleFuelTable;
use App\KfnTables\ManageOrder\VehicleServiceTable;
use App\KfnTables\ManageOrder\VehicleUsageTable;
use App\Models\OfficeRegion;
use App\Models\VehicleFuel;
use App\Models\VehicleService;
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

#[Prefix('vehicle-report')]
#[Name('vehicle-report', dotSuffix: true)]
class VehicleReportController extends Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @param  OfficeRegionTable  $table
     * @param  Request  $request
     *
     * @return View
     */
    // #[Get('', name: 'list', middleware: ['permission:user.show'])]
    #[Get('', name: 'list')]
    public function list(Request $request)
    {
        if (empty($request->input('type'))) {
            $request->merge([
                'type' => 'usage'
            ]);
        }
        
        if ($request->input('type') == 'usage') {
            $table = new VehicleUsageTable();
            $model = new VehicleUsage();

            $this->setTable($table);
        }

        if ($request->input('type') == 'fuel') {
            $table = new VehicleFuelTable();
            $model = new VehicleFuel();

            $this->setTable($table);
        }

        if ($request->input('type') == 'service') {
            $table = new VehicleServiceTable();
            $model = new VehicleService();

            $this->setTable($table);
        }

        if ($request->input('export-excel', false)) {
            $query = $table->query($model);

            if ($query->count() > 0) {
                return $this->export($query, $request->input('type'));
            }
            flash()->error('Tidak ada untuk di ekspor');
        }

      
        $this->setPageTitle('Laporan');

        return $this->view('pages.apps.manage-order.report.list');
    }

     /**
     * @param Request $request
     *
     * @return View
     */
    #[Get('create', name: 'create', middleware: ['permission:office-region.create'])]
    public function create(): View
    {
        $this->setPageTitle("Tambah Kantor Cabang");

        $this->setBackLink(routed('app.office-region.list'));
        return $this->view('pages.apps.data.region.form');
    }

    /**
     * @param Request $request
     * @param OfficeRegion $officeRegion
     *
     * @return View
     */
    #[Get('{officeRegion}/edit', name: 'edit', middleware: ['permission:office-region.update'])]
    public function edit(
        Request $request,
        OfficeRegion $officeRegion
    ): View {

        $this->setPageTitle("Kantor Cabang Detail");
        $this->setBackLink(routed('app.office-region.list'));

        $this->setData('partner', $officeRegion);

        return $this->view('pages.apps.data.region.edit');
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     * @throws \Throwable
     */
    #[Post('', name: 'store', middleware: ['permission:office-region.create'])]
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required',
            'code' => 'nullable|unique:office_regions,code',
            'is_active' => 'required',
            'additional.address' => 'nullable',
        ]);

        $data['name'] = $validated['name'];
        $data['code'] = $validated['code'];
        $data['is_active'] = $validated['is_active'] ?? null;
        $data['additional']['address'] = $validated['additional']['address'] ?? null;

        try {
            DB::beginTransaction();

            $officeRegion = new OfficeRegion();

            $officeRegion->fill($data);
            $officeRegion->save();

            DB::commit();

            flash()->success('Berhasil Menambahkan Kantor Cabang');
        } catch (\Exception $e) {
            DB::rollBack();

            toSentry($e);
            throw_if(app()->hasDebugModeEnabled(), $e);

            flash()->error('Gagal Menambahkan Kantor Cabang');

            return back()->withInput();
        }

        return to_route('app.office-region.list');
    }

    #[Put('{officeRegion}', name: 'update', middleware: ['permission:office-region.update'])]
    public function update(Request $request, OfficeRegion $officeRegion)
    {
        $validated = $request->validate([
            'name' => 'required',
            'code' => [
                    'nullable',
                    Rule::unique('office_regions', 'code')->ignore($officeRegion->id),
                ],
            'is_active' => 'required',
            'additional.address' => 'nullable',
        ]);

        $data['code'] = $validated['code'];
        $data['name'] = $validated['name'];
        $data['additional']['address'] = $validated['additional']['address'] ?? null;
        $data['is_active'] = $validated['is_active'] ?? null;

        try {
            DB::beginTransaction();

            $officeRegion->fill($data);
            $officeRegion->save();

            DB::commit();

            flash()->success('Berhasil update Kantor Cabang');
        } catch (\Exception $e) {
            DB::rollBack();

            toSentry($e);
            throw_if(app()->hasDebugModeEnabled(), $e);

            flash()->error('Gagal update Kantor Cabang');

            return back()->withInput();
        }


        return to_route('app.office-region.list');
    }

    /**
     * @param Request $request
     * @param OfficeRegion $officeRegion
     *
     * @return View
     */
    #[Get('{officeRegion}', name: 'show', middleware: ['permission:office-region.show'])]
    public function show(
        Request $request,
        OfficeRegion $officeRegion
    ): View {

        $this->setPageTitle("Kantor Cabang Detail");
        $this->setBackLink(routed('app.office-region.list'));

        $this->setData('officeRegion', $officeRegion);

        return $this->view('pages.apps.data.region.show');
    }

    /**
     * @param Request $request
     * @param OfficeRegion $officeRegion
     *
     * @return View
     */
    #[Delete('{officeRegion}', name: 'delete', middleware: ['permission:office-region.delete'])]
    public function destroy(
        Request $request,
        OfficeRegion $officeRegion
    ): RedirectResponse|JsonResponse {

        $resp = [
            'rc' => 400,
            'success' => false,
            'message' => 'failed',
        ];
        
        if ($officeRegion->mine()->exists()) {
            $resp['message'] = 'Kantor Cabang tidak bisa dihapus, karena sudah ada tambang terkait.';
            if ($request->ajax()) {
                return response()->json($resp, $resp['rc']);
            }
            flash()->error($resp['message']);
            return back();
        }

        try {
            $officeRegion->delete();

            $resp['rc'] = 200;
            $resp['success'] = true;
            $resp['message'] = 'Kantor Cabang berhasil di hapus';
        } catch (Exception $e) {
            toSentry($e);

            $resp['message'] = 'Kantor Cabang gagal di hapus';
            if (app()->hasDebugModeEnabled()) {
                $resp['message'] .= '<br><br>' . $e->getMessage();
            }
        }

        if ($request->ajax()) {
            return response()->json($resp, $resp['rc']);
        }

        return back();
    }

    public function export($query = null, $type = 'usage')
    {
       
        try {
            if ($type == 'usage') {
                $export = new ExportUsage($query);
            }

            if ($type == 'fuel') {
                $export = new ExportFuel($query);
            }

            if ($type == 'service') {
                $export = new ExportService($query);
            }
            return $export;
        } catch (\Exception $e) {
            toSentry($e);

            flash('Gagal membuat file excel', 'danger');

            return back();
            // return $this->view('pages.apps.finance.list');
        }
    }


    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    #[Get('office-region-search/search', name: 'office-region-search.search', middleware: ['permission:office-region.show'])]
    public function search(Request $request)
    {
        $search = $request->input('search', '');
        $query = OfficeRegion::query()
            ->where('is_active', true)
            ->where(function ($q) use ($search) {
                $q->where('name', 'ilike', "%{$search}%")
                    ->orWhere('code', 'ilike', "%{$search}%");
            });
      
        return response()->json($query->get());
    }
}