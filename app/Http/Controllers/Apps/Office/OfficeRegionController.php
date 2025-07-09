<?php

namespace App\Http\Controllers\Apps\Office;

use App\Http\Controllers\Apps\Controller;
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
     * @param  UserTable  $table
     * @param  Request  $request
     *
     * @return View
     */
    // #[Get('', name: 'list', middleware: ['permission:user.show'])]
    #[Get('', name: 'list')]
    public function list(UserTable $table, Request $request): View
    {
        $table = new UserTable();

        $this->setTable($table);
        $this->setPageTitle('Daftar Kantor Cabang');

        return $this->view('pages.apps.user-management.users.list');
    }

    /**
     * @return View
     * @throws Exception
     */
    // #[Get('create', name: 'create', middleware: ['permission:user.create'])]
    #[Get('create', name: 'create')]
    public function create(): View
    {
        $this->setPageTitle("User");

        $this->setData('role_partner', Role::query()->whereNot('type', 'owner')->whereNot('type', 'partner')->get());
        $this->setData('partner', Partner::query()->get());

        $this->setBackLink(routed('app.user.list'));
        return $this->view('pages.apps.user-management.users.form');
    }

    /**
     * @param  Request  $request
     * @param  User  $user
     *
     * @return View
     * @throws Exception
     */
    // #[Get('{user}/edit', name: 'edit', middleware: ['permission:user.update'])]
    #[Get('{user}/edit', name: 'edit')]
    public function edit(
        Request $request,
        User $user
    ): View {

        $this->setPageTitle("User Detail");
        $this->setBackLink(routed('app.user.list'));

        $this->setData('roles', Role::query()->whereNot('type', 'owner')->whereNot('type', 'partner')->get());
        $this->setData('user', $user);

        return $this->view('pages.apps.user-management.users.edit');
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     * @throws \Throwable
     */
    // #[Post('', name: 'store', middleware: ['permission:user.create'])]
    #[Post('', name: 'store')]
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required',
            'username' =>  ['required', 'string', 'min:3', 'max:20', 'unique:users,username',],
            'phone' => 'nullable',
            'email' => 'required|email|unique:users,email',
            'password' => 'nullable',
            'role' => 'nullable|array',
            'type' => 'required',
            // 'identity_type' => 'nullable',
            // 'identity_number' => 'nullable',
        ]);

        $data['name'] = $validated['name'];
        $data['username'] = $validated['username'];
        $data['phone'] = $validated['phone'];
        $data['email'] = $validated['email'];
        $data['type'] = $validated['type'];
        // $data['identity_type'] = $validated['identity_type'];
        // $data['identity_number'] = $validated['identity_number'];
        $data['email_verified_at'] = now();
        $data['password'] = Hash::make('password');

        try {
            DB::beginTransaction();

            $user = new User();

            $user->fill($data);
            $user->save();

            // Notification::route('mail', $data['email'])
            //     ->notify(new CredentiialNotification($data));
            if (!empty($validated['role'])) {
                $user->syncRoles($validated['role']);
            }

            DB::commit();

            flash()->success('Berhasil Menambahkan akun');
        } catch (\Exception $e) {
            DB::rollBack();

            throw_if(app()->hasDebugModeEnabled(), $e);

            flash()->error('Gagal Menambahkan akun');

            return back()->withInput();
        }


        return to_route('app.user.list');
    }

    // #[Put('{user}', name: 'update', middleware: ['permission:user.update'])]
    #[Put('{user}', name: 'update')]
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required',
            'username' =>  'required|string|min:3|max:20|unique:users,username,' . $user->id,
            'phone' => 'nullable',
            'email' => 'required|email|unique:users,email,' . $user->id,
            // 'identity_type' => 'nullable',
            // 'identity_number' => 'nullable',
            'status' => 'nullable',
            'role' => 'nullable|array',
            'type' => 'required',
        ]);


        $data['name'] = $validated['name'];
        $data['username'] = $validated['username'];
        $data['phone'] = $validated['phone'];
        $data['email'] = $validated['email'];
        $data['type'] = $validated['type'];
        // $data['identity_type'] = $validated['identity_type'];
        // $data['identity_number'] = $validated['identity_number'];

        $data['status'] = $validated['status'] ?? 'non-active';
        $data['password'] = $user->password;
        try {
            DB::beginTransaction();

            $user->fill($data);
            $user->save();

            if (!empty($validated['role'])) {
                $user->syncRoles($validated['role']);
            }

            DB::commit();

            flash()->success('Berhasil update Akun');
        } catch (\Exception $e) {
            DB::rollBack();

            throw_if(app()->hasDebugModeEnabled(), $e);

            flash()->error('Gagal update Akun');

            return back()->withInput();
        }


        return to_route('app.user.list');
    }

    /**
     * @param Request $request
     * @param User $user
     *
     * @return View
     */
    // #[Get('{user}', name: 'show', middleware: ['permission:user.show'])]
    #[Get('{user}', name: 'show')]
    public function show(
        Request $request,
        User $user
    ): View {

        $this->setPageTitle("User Detail");
        $this->setBackLink(routed('app.user.list'));

        $roles = Role::query();

        $this->setData('roles', $roles->whereNot('type', 'owner')->whereNot('type', 'partner')->get());
        $this->setData('user', $user);

        return $this->view('pages.apps.user-management.users.show');
    }

    /**
     * @param Request $request
     * @param User $user
     *
     * @return View
     */
    // #[Delete('{user}', name: 'delete', middleware: ['permission:user.delete'])]
    #[Delete('{user}', name: 'delete')]
    public function destroy(
        Request $request,
        User $user
    ): RedirectResponse|JsonResponse {

        $resp = [
            'rc' => 400,
            'success' => false,
            'message' => 'failed',
        ];

        try {

            $user->delete();

            $resp['rc'] = 200;
            $resp['success'] = true;
            $resp['message'] = 'Akun berhasil di hapus';
        } catch (Exception $e) {
            $resp['message'] = 'Akun gagal di hapus';
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
     * @param Travel $travel
     *
     */
    #[Get('user-search/search', name: 'user-search.search')]
    public function search(
        Request $request,
    ) {
        // saya ingin mencari data parkir berdasarkan tipe
        $search = $request->input('search', '');
        $travelId = $request->input('travel_id', null);
        $type = $request->input('type'); // default type is 'user'

        $query = User::query()
            ->where(function ($q) use ($search) {
                $q->where('name', 'ilike', "%{$search}%")
                    ->orWhere('phone', 'ilike', "%{$search}%")
                    ->orWhere('email', 'ilike', "%{$search}%");
            });
       
        if (session('select_partner_id') && !in_array($type, ['rm', 'specialist', 'fop', 'pic_pihk'])) {
            $query->where('partner_id', session('select_partner_id') ?? null);
        }

        if (authPartnerId()) {
            $query->where('partner_id', authPartnerId() ?? null);
        }

        if (!empty($type)) {
            $query->where('type', $type);
            if ($type = 'pic_pihk') {
                $query->where('travel_id', $travelId ?? null);
            }
        }

        $query->orderBy('name', 'asc');

        return response()->json($query->get());
    }
}
