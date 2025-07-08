<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Apps\Controller;
use App\Models\Dataset\Customer;
use App\Models\Institution;
use App\Vendor\Permission\Models\Role;
use App\KfnTables\Dataset\CustomerTable;
use App\KfnTables\UserManagement\RoleTable;
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
use Illuminate\Support\Str;

#[Prefix('role')]
#[Name('role', dotSuffix: true)]
class RoleController extends Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @param Request $request
     *
     * @throws \Throwable
     * @return View
     */
    #[Get('', name: 'list', middleware: ['permission:role.show'])]
    public function list(RoleTable $table, Request $request): View
    {
        $this->setTable($table);
        $this->setPageTitle('Daftar Role');

        return $this->view('pages.apps.user-management.roles.list');
    }

    /**
     * @param Request $request
     * @param Role $role
     *
     * @return View
     */
    #[Get('{role}', name: 'show', middleware: ['permission:role.show'])]
    public function show(
        Request $request,
        Role $role
    ): View {

        $this->setPageTitle("Role Detail");
        $this->setBackLink(routed('app.role.list'));

        $request['user_id'] = $role->users()->pluck('id');

        $table = new UserTable();

        $this->setTable($table);
        $this->setData('role', $role);

        return $this->view('pages.apps.user-management.roles.show');
    }
}
