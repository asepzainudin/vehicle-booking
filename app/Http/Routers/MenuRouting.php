<?php

namespace App\Http\Routers;

class MenuRouting extends \Dentro\Yalr\BaseRoute
{
    /**
     * @inheritDoc
     */
    public function register(): void
    {
        //
    }

    public function afterRegister(): void
    {
        menus()->add('default', 'Default');

        $this->travel();
        $this->userManagement();
    }

    public function travel(): void
    {
        menus()
            ->add(
                name: 'app.office',
                title: 'Kantor',
            )
            ->get('app.office')
            ->route(
                name: 'app.office-region.list',
                title: 'Kantor Cabang',
                attribute: [
                    'icon' => 'plus-circle',
                ],
                resolver: function () {
                    return auth()->user()?->hasAnyRole(['super-admin', 'admin']) ?? false;
                }
            )
            ->route(
                name: 'app.mine.list',
                title: 'Tambang',
                attribute: [
                    'icon' => 'plus-circle',
                ],
                resolver: function () {
                    return auth()->user()?->hasAnyRole(['super-admin', 'admin']) ?? false;
                }
            );
    }

    public function userManagement(): void
    {
        menus()
            ->add(
                name: 'app.user',
                title: 'User Management',
            )
            ->get('app.user', resolvedOnly: false)
            // ->route(
            //     name: 'app.setting.list',
            //     title: 'Pengaturan',
            //     attribute: [
            //         'icon' => 'setting-4',
            //     ],
            //     resolver: function () {
            //         return auth()->user()?->hasAnyRole(['admin', 'admin-partner']) ?? false;
            //     }
            // )
            // ->route(
            //     name: 'app.office-region.list',
            //     title: 'Kantor Cabang',
            //     attribute: [
            //         'icon' => 'plus-circle',
            //     ],
            //     resolver: function () {
            //         return auth()->user()?->hasAnyRole(['super-admin', 'admin']) ?? false;
            //     }
            // )
            ->route(
                name: 'app.role.list',
                title: 'Role',
                attribute: [
                    'icon' => 'people',
                ],
                resolver: function () {
                    return auth()->user()?->hasAnyRole(['super-admin', 'admin']) ?? false;
                }
            );
    }
}
