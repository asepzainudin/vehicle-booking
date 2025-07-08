<?php

namespace Database\Seeders;

use App\Vendor\Permission\Models\Permission;
use App\Vendor\Permission\Models\Role;
use Illuminate\Database\Seeder;

class SeedPermission extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = Role::query()->get()->keyBy('name');

        foreach ($this->permission() as $key => $permission) {
            Permission::query()->updateOrCreate(['name' => $permission['name']], ['label' => $permission['label']]);
            foreach ((array) $permission['role'] ?? [] as $key => $value) {
                $role = $roles->get($value);
                if ($role instanceof Role) {
                    $role->givePermissionTo($permission['name']);
                }
            }
        }
    }
    private function permission(): array
    {
        
        //Permission partner
        $partner = [
            'partner' =>  ['show', 'create', 'update', 'delete']
        ];

        foreach ($partner as $keyPartner => $_partner) {
            foreach ($_partner as $key => $type) {
                $permission[] = [
                    'name' => $keyPartner . '.' . $type,
                    'label' => ucfirst($keyPartner)  . ' ' . $type,
                    'role' => ['admin', 'super-admin']
                ];
            }
        }
        
        //Permission travel
        $travel = [
            'dashboard' => ['show'],
            'travel' => ['show', 'create', 'update', 'delete', 'status'],
        ];

        foreach ($travel as $keyTravel => $_travel) {
            foreach ($_travel as $key => $type) {
                $permission[] = [
                    'name' => 'travel.'. $keyTravel . '.' . $type,
                    'label' => 'Travel ' . ucfirst($keyTravel)  . ' ' . $type,
                    'role' => ['admin', 'super-admin', 'admin-partner', 'fop_approval']
                ];
                if ($type == 'show' || $type == 'create' || $type == 'update' || $type == 'delete') {
                    $permission[] = [
                        'name' => 'travel.'. $keyTravel . '.' . $type,
                        'label' => 'Travel ' . ucfirst($keyTravel)  . ' ' . $type,
                        'role' => ['fop_maker']
                    ];
                }

                if ($type == 'show') {
                    $permission[] = [
                        'name' => 'travel.'. $keyTravel . '.' . $type,
                        'label' => 'Travel ' . ucfirst($keyTravel)  . ' ' . $type,
                        'role' => ['rm', 'pic_pihk', 'specialist', 'airline']
                    ];
                }
            }
        }

        //Permission financing plafon
        $plafon = [
            'plafon' => ['show', 'create', 'update', 'delete', 'status'],
        ];

        foreach ($plafon as $keyPlafon => $_plafon) {
            foreach ($_plafon as $key => $type) {
                $permission[] = [
                    'name' => 'plafon.'. $keyPlafon . '.' . $type,
                    'label' => 'Plafon ' . ucfirst($keyPlafon)  . ' ' . $type,
                    'role' => ['admin', 'super-admin', 'admin-partner', 'fop_approval']
                ];

                if ($type == 'show' || $type == 'create' || $type == 'update' || $type == 'delete') {
                    $permission[] = [
                        'name' => 'plafon.'. $keyPlafon . '.' . $type,
                        'label' => 'Plafon ' . ucfirst($keyPlafon)  . ' ' . $type,
                        'role' => ['fop_maker']
                    ];
                }

                if ($type == 'show') {
                    $permission[] = [
                        'name' => 'plafon.'. $keyPlafon . '.' . $type,
                        'label' => 'Plafon ' . ucfirst($keyPlafon)  . ' ' . $type,
                        'role' => ['rm', 'pic_pihk', 'specialist', 'airline']
                    ];
                }
            }
        }

        //Permission financing disbursement
        $disbursement = [
            'disbursement' => ['show', 'create', 'update', 'delete', 'status'],
        ];

        foreach ($disbursement as $keyDisbursement => $_disbursement) {
            foreach ($_disbursement as $key => $type) {
                $permission[] = [
                    'name' => 'disbursement.'. $keyDisbursement . '.' . $type,
                    'label' => 'Disbursement ' . ucfirst($keyDisbursement)  . ' ' . $type,
                    'role' => ['admin', 'super-admin', 'admin-partner', 'fop_approval']
                ];
                
                if ($type == 'show' || $type == 'create' || $type == 'update' || $type == 'delete') {
                    $permission[] = [
                        'name' => 'disbursement.'. $keyDisbursement . '.' . $type,
                        'label' => 'Disbursement ' . ucfirst($keyDisbursement)  . ' ' . $type,
                        'role' => ['fop_maker']
                    ];
                }

                if ($type == 'show') {
                    $permission[] = [
                        'name' => 'disbursement.'. $keyDisbursement . '.' . $type,
                        'label' => 'Disbursement ' . ucfirst($keyDisbursement)  . ' ' . $type,
                        'role' => ['rm', 'pic_pihk', 'specialist', 'airline']
                    ];
                }
            }
        }

        
        //Permission financing repayment
        $repayment = [
            'repayment' => ['show', 'create', 'update', 'delete', 'status'],
        ];

        foreach ($repayment as $keyRepayment => $_repayment) {
            foreach ($_repayment as $key => $type) {
                $permission[] = [
                    'name' => 'repayment.'. $keyRepayment . '.' . $type,
                    'label' => 'Repayment ' . ucfirst($keyRepayment)  . ' ' . $type,
                    'role' => ['admin', 'super-admin', 'admin-partner', 'fop_approval']
                ];

                if ($type == 'show' || $type == 'create' || $type == 'update' || $type == 'delete') {
                    $permission[] = [
                        'name' => 'repayment.'. $keyRepayment . '.' . $type,
                        'label' => 'Repayment ' . ucfirst($keyRepayment)  . ' ' . $type,
                        'role' => ['fop_maker']
                    ];
                }
                if ($type == 'show') {
                    $permission[] = [
                        'name' => 'repayment.'. $keyRepayment . '.' . $type,
                        'label' => 'Repayment ' . ucfirst($keyRepayment)  . ' ' . $type,
                        'role' => ['rm', 'pic_pihk', 'specialist', 'airline']
                    ];
                }
            }
        }

        return $permission;
    }
}
