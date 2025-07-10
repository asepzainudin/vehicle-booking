<?php

// use App\Http\Routers;
use App\Http\Controllers\Api;
use App\Http\Controllers\Apps;
use App\Http\Controllers\Web;
use PHPUnit\Event\Telemetry\System;

return [

    /*
    |--------------------------------------------------------------------------
    | Preloads
    |--------------------------------------------------------------------------
    | String of class name that instance of \Dentro\Yalr\Contracts\Bindable
    | Preloads will always been called even when laravel routes has been cached.
    | It is the best place to put Rate Limiter and route binding related code.
    */

    'preloads' => [
        //
    ],

    /*
    |--------------------------------------------------------------------------
    | Router group settings
    |--------------------------------------------------------------------------
    | Groups are used to organize and group your routes. Basically the same
    | group that used in common laravel route.
    |
    | 'group_name' => [
    |     // laravel group route options can contains 'middleware', 'prefix',
    |     // 'as', 'domain', 'namespace', 'where'
    | ]
    */

    'groups' => [
        'web' => [
            'middleware' => 'web',
            'prefix' => '',
        ],
        'app' => [
            'middleware' => ['web', 'auth:sanctum'],
            'prefix' => 'app',
            'as' => 'app.',
        ],
        'api' => [
            'middleware' => ['api', 'auth:sanctum'],
            'prefix' => 'api',
            'as' => 'api.',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Routes
    |--------------------------------------------------------------------------
    | Below is where our route is loaded, it read `groups` section above.
    | keys in this array are the name of route group and values are string
    | class name either instance of \Dentro\Yalr\Contracts\Bindable or
    | controller that use attribute that inherit \Dentro\Yalr\RouteAttribute
    */

    'web' => [
        /** @inject web * */
    ],
    'app' => [

        //Profile
        Apps\ProfileController::class,

        //User Management
        Apps\UserController::class,
        Apps\RoleController::class,

        //Master data
        Apps\Data\OfficeRegionController::class,
        Apps\Data\MineController::class,
        Apps\Data\VehicleController::class,

        //Manage Order
        Apps\ManageOrder\DashboardController::class,
        Apps\ManageOrder\VehicleOrderController::class,
        Apps\ManageOrder\VehicleUsageController::class,
        Apps\ManageOrder\VehicleFuelController::class,
        Apps\ManageOrder\VehicleServiceController::class,
        Apps\ManageOrder\VehicleReportController::class,

        /** @inject app * */
        \App\Http\Routers\MenuRouting::class,
    ],
    'api' => [
        Api\SettingController::class,
        /** @inject api * */
    ],


];
