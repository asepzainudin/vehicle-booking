<?php

namespace App\Http\Controllers\Apps\Data;

use App\Http\Controllers\Apps\Controller;
use App\KfnTables\Data\MineTable;
use App\Models\Mine;
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

#[Prefix('mine')]
#[Name('mine', dotSuffix: true)]
class MineController extends Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @param  Mine $table
     * @param  Request  $request
     *
     * @return View
     */
    // #[Get('', name: 'list', middleware: ['permission:user.show'])]
    #[Get('', name: 'list')]
    public function list(MineTable $table, Request $request): View
    {
        $table = new MineTable();

        $this->setTable($table);
        $this->setPageTitle('Daftar Tambang');

        return $this->view('pages.apps.data.mine.list');
    }

     /**
     * @param Request $request
     *
     * @return View
     */
    #[Get('create', name: 'create', middleware: ['permission:mine.create'])]
    public function create(): View
    {
        $this->setPageTitle("Tambah Tambang");

        $this->setBackLink(routed('app.mine.list'));
        return $this->view('pages.apps.data.mine.form');
    }

    /**
     * @param Request $request
     * @param Mine $mine
     *
     * @return View
     */
    #[Get('{mine}/edit', name: 'edit', middleware: ['permission:mine.update'])]
    public function edit(
        Request $request,
    Mine $mine
    ): View {

        $this->setPageTitle("Tambang Detail");
        $this->setBackLink(routed('app.mine.list'));

        $this->setData('partner', $mine);

        return $this->view('pages.apps.data.mine.edit');
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     * @throws \Throwable
     */
    #[Post('', name: 'store', middleware: ['permission:mine.create'])]
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required',
            'code' => 'nullable|unique:mine,code',
            'office_region_id' => 'required|exists:office_regions,id',
            'is_active' => 'required',
            'additional.address' => 'nullable',
        ]);

        $data['name'] = $validated['name'];
        $data['code'] = $validated['code'];
        $data['office_region_id'] = $validated['office_region_id'] ?? null;
        $data['is_active'] = $validated['is_active'] ?? null;
        $data['additional']['address'] = $validated['additional']['address'] ?? null;

        try {
            DB::beginTransaction();

            $mine = new Mine();

            $mine->fill($data);
            $mine->save();

            DB::commit();

            flash()->success('Berhasil Menambahkan Tambang');
        } catch (\Exception $e) {
            DB::rollBack();

            toSentry($e);
            throw_if(app()->hasDebugModeEnabled(), $e);

            flash()->error('Gagal Menambahkan Tambang');

            return back()->withInput();
        }

        return to_route('app.mine.list');
    }

    #[Put('{mine}', name: 'update', middleware: ['permission:mine.update'])]
    public function update(Request $request, Mine $mine)
    {
        $validated = $request->validate([
            'name' => 'required',
            'code' => [
                    'nullable',
                    Rule::unique('office_regions', 'code')->ignore($mine->id),
                ],
            'office_region_id' => 'required|exists:office_regions,id',
            'is_active' => 'required',
            'additional.address' => 'nullable',
            
        ]);

        $data['name'] = $validated['name'];
        $data['code'] = $validated['code'];
        $data['office_region_id'] = $validated['office_region_id'] ?? null;
        $data['is_active'] = $validated['is_active'] ?? null;
        $data['additional']['address'] = $validated['additional']['address'] ?? null;

        try {
            DB::beginTransaction();

            $mine->fill($data);
            $mine->save();

            DB::commit();

            flash()->success('Berhasil update Tambang');
        } catch (\Exception $e) {
            DB::rollBack();

            toSentry($e);
            throw_if(app()->hasDebugModeEnabled(), $e);

            flash()->error('Gagal update Tambang');

            return back()->withInput();
        }

        return to_route('app.mine.list');
    }

    /**
     * @param Request $request
     * @param Mine $mine
     *
     * @return View
     */
    #[Get('{mine}', name: 'show', middleware: ['permission:mine.show'])]
    public function show(
        Request $request,
        Mine $mine
    ): View {

        $this->setPageTitle("Tambang Detail");
        $this->setBackLink(routed('app.mine.list'));

        $this->setData('mine', $mine);

        return $this->view('pages.apps.data.mine.show');
    }

    /**
     * @param Request $request
     * @param Mine $mine
     *
     * @return View
     */
    #[Delete('{mine}', name: 'delete', middleware: ['permission:mine.delete'])]
    public function destroy(
        Request $request,
        Mine $mine
    ): RedirectResponse|JsonResponse {

        $resp = [
            'rc' => 400,
            'success' => false,
            'message' => 'failed',
        ];
        
        try {
            $mine->delete();

            $resp['rc'] = 200;
            $resp['success'] = true;
            $resp['message'] = 'Tambang berhasil di hapus';
        } catch (Exception $e) {
            toSentry($e);

            $resp['message'] = 'Tambang gagal di hapus';
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