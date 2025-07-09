<?php

namespace App\Http\Controllers\Apps\Office;

use App\Http\Controllers\Apps\Controller;
use App\KfnTables\Office\OfficeRegionTable;
use App\Models\Partner\Partner;
use App\Models\User;
use App\Vendor\Permission\Models\Role;
use App\KfnTables\UserManagement\UserTable;
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
use Illuminate\Support\Facades\Hash;

#[Prefix('office-region')]
#[Name('office-region', dotSuffix: true)]
class OfficeRegionController extends Controller
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
    public function list(OfficeRegionTable $table, Request $request): View
    {
        $table = new OfficeRegionTable();

        $this->setTable($table);
        $this->setPageTitle('Daftar Kantor Cabang');

        return $this->view('pages.apps.office.region.list');
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
        return $this->view('pages.apps.office.region.form');
    }

    /**
     * @param Request $request
     * @param Airline $partner
     *
     * @return View
     */
    #[Get('{partner}/edit', name: 'edit', middleware: ['permission:partner.update'])]
    public function edit(
        Request $request,
        Airline $partner
    ): View {

        $this->setPageTitle("Maskapai Detail");
        $this->setBackLink(routed('app.partner.list'));

        $this->setData('partner', $partner);

        return $this->view('pages.apps.user-management.partner.edit');
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     * @throws \Throwable
     */
    #[Post('', name: 'store', middleware: ['permission:partner.create'])]
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required',
            'code' => 'required|unique:partners,code',
            'status' => 'required',
            'address' => 'nullable',
        ]);

        $data['name'] = $validated['name'];
        $data['code'] = $validated['code'];
        $data['status'] = $validated['status'] ?? 'non-active';
        $data['address'] = $validated['address'];

        try {
            DB::beginTransaction();

            $partner = new Airline();

            $partner->fill($data);
            $partner->save();

            // default user
            $dataUser['partner_id'] = $partner->id;
            $dataUser['name'] =' Admin '.$partner->name;
            $dataUser['username'] = 'admin.'.$partner->code;
            $dataUser['phone'] = $validated['phone'] ?? null;
            $dataUser['email'] = 'admin.'. $partner->code .'@'. config('app.email_suffix');
            $dataUser['status'] = $validated['status'] ?? 'non-active';
            $dataUser['email_verified_at'] = now();
            $dataUser['password'] = Hash::make('password') ;

            $user = new User();

            $user->fill($dataUser);
            $user->save();

            $user->assignRole('admin-partner');

            DB::commit();

            flash()->success('Berhasil Menambahkan Maskapai');
        } catch (\Exception $e) {
            DB::rollBack();

            toSentry($e);
            throw_if(app()->hasDebugModeEnabled(), $e);

            flash()->error('Gagal Menambahkan Maskapai');

            return back()->withInput();
        }

        return to_route('app.partner.list');
    }

    #[Put('{partner}', name: 'update', middleware: ['permission:partner.update'])]
    public function update(Request $request, Partner $partner)
    {
        $validated = $request->validate([
            'name' => 'required',
            'code' => [
                    'required',
                    Rule::unique('partners', 'code')->ignore($partner->id),
                ],
            'status' => 'required',
            'address' => 'nullable',
        ]);

        $data['code'] = $validated['code'];
        $data['name'] = $validated['name'];
        // $data['status'] = $validated['status'] ?? 'non-active';
        // $data['address'] = $validated['address'];

        try {
            DB::beginTransaction();

            $partner->fill($data);
            $partner->save();

            DB::commit();

            flash()->success('Berhasil update Maskapai');
        } catch (\Exception $e) {
            DB::rollBack();

            toSentry($e);
            throw_if(app()->hasDebugModeEnabled(), $e);

            flash()->error('Gagal update Maskapai');

            return back()->withInput();
        }


        return to_route('app.partner.list');
    }

    /**
     * @param Request $request
     * @param Partner $partner
     *
     * @return View
     */
    #[Get('{partner}', name: 'show', middleware: ['permission:partner.show'])]
    public function show(
        Request $request,
        Partner $partner
    ): View {

        $this->setPageTitle("Maskapai Detail");
        $this->setBackLink(routed('app.partner.list'));

        $this->setData('partner', $partner);

        return $this->view('pages.apps.user-management.partner.show');
    }

    /**
     * @param Request $request
     * @param Partner $partner
     *
     * @return View
     */
    #[Delete('{partner}', name: 'delete', middleware: ['permission:partner.delete'])]
    public function destroy(
        Request $request,
        Partner $partner
    ): RedirectResponse|JsonResponse {

        $resp = [
            'rc' => 400,
            'success' => false,
            'message' => 'failed',
        ];
        
        if ($partner->travels()->exists()) {
            $resp['message'] = 'Maskapai tidak bisa dihapus, karena sudah ada travel terkait.';
            if ($request->ajax()) {
                return response()->json($resp, $resp['rc']);
            }
            flash()->error($resp['message']);
            return back();
        }

        if ($partner->users()->exists()) {
            $resp['message'] = 'Maskapai tidak bisa dihapus, karena sudah ada user terkait.';
            if ($request->ajax()) {
                return response()->json($resp, $resp['rc']);
            }
            flash()->error($resp['message']);
            return back();
        }

        try {

            $partner->delete();

            $resp['rc'] = 200;
            $resp['success'] = true;
            $resp['message'] = 'Maskapai berhasil di hapus';
        } catch (Exception $e) {
            toSentry($e);

            $resp['message'] = 'Maskapai gagal di hapus';
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
     * @return RedirectResponse
     * @throws \Throwable
     */
    #[Post('/set/session', name: 'set.session')]
    public function setPartner(Request $request)
    {
        session(['select_partner_id' => $request->select_partner_id ?? null]);
        return response()->json(['success' => true]);
    }
}