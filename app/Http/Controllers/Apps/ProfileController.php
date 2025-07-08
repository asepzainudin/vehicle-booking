<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Apps\Controller;
use App\Models\User;
use App\Vendor\Permission\Models\Role;
use App\KfnTables\Profile\ProfileTable;
use App\Models\Partner\Partner;
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
use Illuminate\Support\Facades\Notification;
use Illuminate\Validation\Rule;

#[Prefix('profile')]
#[Name('profile', dotSuffix: true)]
class ProfileController extends Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @param  User  $user
     * @param  Request  $request
     *
     * @return View
     */
    #[Get('{user}/user', name: 'user')]
    public function profile(User $user, Request $request): View
    {
        $this->setPageTitle('Profile');
        $this->setData('user', $user);

        return $this->view('pages.apps.profile.partials.profile');
    }

    /**
     * @return View
     * @throws Exception
     */
    // #[Get('create', name: 'create', middleware: ['permission:user.create'])]
    #[Get('create', name: 'create')]
    public function createAccount(): View
    {
        $this->setPageTitle("User");

        $this->setData('role_partner', Role::query()->where('type', 'partner')->get());
        $this->setData('partner', Partner::query()->get());

        $this->setBackLink(routed('app.profile.user', auth()->user()->hash));
        return $this->view('pages.apps.profile.partials.form-user');
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

        $this->setPageTitle("Profile");
        $this->setBackLink(routed('app.profile.accounts', $user->hash));

        $roles = Role::query();
        $this->setData('roles', $roles->where('type', 'partner')->get());
        $this->setData('user', $user);

        return $this->view('pages.apps.profile.edit');
    }

     /**
     * @param  Request  $request
     * @param  User  $user
     *
     * @return View
     * @throws Exception
     */
    #[Get('{user}/accounts', name: 'accounts')]
    public function accounts(
        Request $request,
        User $user, ProfileTable $table
    ): View {

        $this->setPageTitle("Akun");

        $table = new ProfileTable();

        $this->setTable($table);
        $this->setData('user', $user);

        return $this->view('pages.apps.profile.partials.account');
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
            'select_partner_id' => 'nullable',
            'travel_id' => 'nullable',
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

        $data['partner_id'] =  $validated['select_partner_id'] == 0 ? null : $validated['select_partner_id'];
        $data['travel_id'] =  $validated['travel_id'] ?? null;
        $data['name'] = $validated['name'];
        $data['username'] = $validated['username'];
        $data['phone'] = $validated['phone'];
        $data['email'] = $validated['email'];
        $data['type'] = $validated['type'];
        // $data['identity_type'] = $validated['identity_type'];
        // $data['identity_number'] = $validated['identity_number'];
        $data['email_verified_at'] = now();
        $data['password'] = Hash::make('password') ;

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

        return to_route('app.profile.accounts', auth()->user()->hash);
    }

    // #[Put('{user}', name: 'update', middleware: ['permission:user.update'])]
    #[Put('{user}', name: 'update')]
    public function update(User $user, Request $request)
    {
        $validated = $request->validate([
            'select_partner_id' => 'nullable',
            'travel_id' => 'nullable',
            'name' => 'required',
            'username' =>  [
                'required',
                Rule::unique('users', 'username')->ignore($user->id),
            ],
            'phone' => 'nullable',
            'email' => [
                'required',
                Rule::unique('users', 'email')->ignore($user->id),
            ],
            'password' => 'nullable',
            'role' => 'nullable|array',
            'type' => 'required',
            // 'identity_type' => 'nullable',
            // 'identity_number' => 'nullable',
        ]);

        $data['partner_id'] =  $validated['select_partner_id'] == 0 ? null : $validated['select_partner_id'];
        $data['travel_id'] =  $validated['travel_id'] ?? null;
        $data['name'] = $validated['name'];
        $data['username'] = $validated['username'];
        $data['phone'] = $validated['phone'];
        $data['email'] = $validated['email'];
        $data['type'] = $validated['type'];

        $validated['password'] ? $data['password'] = Hash::make($validated['password']) : '';
        // $data['identity_type'] = $validated['identity_type'];
        // $data['identity_number'] = $validated['identity_number'];

        try {
            DB::beginTransaction();

            $user->fill($data);
            $user->save();

            if (!empty($validated['role'])) {
                $user->syncRoles($validated['role']);
            }

            DB::commit();

            flash()->success('Berhasil update Profile');
        } catch (\Exception $e) {
            DB::rollBack();

            throw_if(app()->hasDebugModeEnabled(), $e);

            flash()->error('Gagal update Profile');

            return back()->withInput();
        }


        return to_route('app.profile.edit', $user->hash);
    }

    /**
     * @param Request $request
     * @param User $user
     *
     * @return View
     */
    // #[Get('{user}', name: 'show', middleware: ['permission:user.show'])]
    #[Get('{user}/show', name: 'show')]
    public function show(
        Request $request,
        User $user
    ): View {

        $this->setPageTitle("User Detail");
        $this->setBackLink(routed('app.profile.accounts', $user->hash));

        $roles = Role::query();

        $this->setData('roles', $roles->where('type', 'partner')->get());
        $this->setData('user', $user);
        
        return $this->view('pages.apps.profile.partials.show-user');
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
}
