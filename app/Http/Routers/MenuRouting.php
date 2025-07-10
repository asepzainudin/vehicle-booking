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

        $this->masterData();
        $this->manageOrder();
        // $this->userManagement();
    }

    public function masterData(): void
    {
        menus()
            ->add(
                name: 'app.master-data',
                title: 'Master Data',
            )
            ->get('app.master-data')
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
            )
            ->route(
                name: 'app.vehicle.list',
                title: 'Kendaraan',
                attribute: [
                    'icon' => 'plus-circle',
                ],
                resolver: function () {
                    return auth()->user()?->hasAnyRole(['super-admin', 'admin']) ?? false;
                }
            );
    }

    public function manageOrder(): void
    {
        menus()
            ->add(
                name: 'app.manage-order',
                title: 'Kelola Pemesanan',
            )
            ->get('app.manage-order')
            ->route(
                name: 'app.vehicle-dashboard.dashboard',
                title: 'Dashboard',
                attribute: [
                    'icon' => 'chart-simple-2',
                ],
                resolver: function () {
                    return auth()->user()?->hasAnyRole(['super-admin', 'admin', 'reviewer', 'approval']);
                }
            )
            ->route(
                name: 'app.vehicle-order.list',
                title: 'Pemesanan',
                attribute: [
                    'icon' => 'plus-circle',
                ],
                resolver: function () {
                    return auth()->user()?->hasAnyRole(['super-admin', 'admin', 'reviewer', 'approval', 'driver']);
                }
            )
            ->route(
                name: 'app.vehicle-report.list',
                title: 'Laporan Pemesanan',
                attribute: [
                    'icon' => 'chart-simple-2',
                ],
                resolver: function () {
                    return auth()->user()?->hasAnyRole(['super-admin', 'admin', 'reviewer', 'approval']) ?? false;
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
