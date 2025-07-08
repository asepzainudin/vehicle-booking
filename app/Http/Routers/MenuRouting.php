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
                name: 'app.travel',
                title: 'Pembiayaan',
            )
            ->get('app.travel', resolvedOnly: false)
            // ->route(
            //     name: 'app.travel-dashboard.dashboard',
            //     title: 'Dashboard',
            //     attribute: [
            //         'icon' => 'chart-simple-2',
            //     ],
            //     resolver: function () {
            //         return auth()->user()?->hasAnyRole(['admin-partner']) ?? false;
            //     }
            // )
            ->route(
                name: 'app.travel.list',
                title: 'Biro Rekanan',
                attribute: [
                    'icon' => 'airplane-square',
                ],
                resolver: function () {
                    return true;
                }
            )
            ->route(
                name: 'app.plafon.list',
                title: 'Plafon Pembiayaan',
                attribute: [
                    'icon' => 'two-credit-cart',
                ],
                resolver: function () {
                    return true;
                }
            )
            ->route(
                name: 'app.disbursement.list',
                title: 'Pencairan Pembiayaan',
                attribute: [
                    'icon' => 'bank',
                ],
                resolver: function () {
                    return true;
                }
            )
            ->route(
                name: 'app.repayment.list',
                title: 'Pelunasan Pembiayaan',
                attribute: [
                    'icon' => 'paypal',
                ],
                resolver: function () {
                    return true;
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
            ->route(
                name: 'app.partner.list',
                title: 'Maskapai',
                attribute: [
                    'icon' => 'airplane-square',
                ],
                resolver: function () {
                    return auth()->user()?->hasAnyRole(['super-admin', 'admin']) ?? false;
                }
            )
            ->route(
                name: 'app.user.list',
                title: 'Akun Master',
                attribute: [
                    'icon' => 'user-square',
                ],
                resolver: function () {
                    return auth()->user()?->hasAnyRole(['super-admin', 'admin']) ?? false;
                }
            )
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
