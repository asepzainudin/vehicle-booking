<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\{Exceptions, Middleware};
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withCommands([
        __DIR__.'/../app/Core/Notification/Console',
    ])
    ->withEvents([
        __DIR__.'/../app/Core/Notification/Events',
        __DIR__.'/../app/Core/Notification/Listeners',
    ])
    ->withMiddleware(function (Middleware $middleware) {
        //
        $middleware->statefulApi();
        $middleware->redirectGuestsTo(fn (Request $request) => routed('auth.login'));
        $middleware->alias([
            'role' => \Spatie\Permission\Middleware\RoleMiddleware::class,
            'permission' => \Spatie\Permission\Middleware\PermissionMiddleware::class,
            'role_or_permission' => \Spatie\Permission\Middleware\RoleOrPermissionMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
        \Sentry\Laravel\Integration::handles($exceptions);
        $exceptions->renderable(function (Throwable $e, Request $request) {
            $apiPrefixes = collect((array) config('koffinate.base.api_prefixes', []));
            $apiPrefixes->each(fn ($it) => $apiPrefixes->add($it . '/*'));
            if ($request->is($apiPrefixes->toArray())) {
                \Kfn\Base\Exceptions\KfnException::renderException($request, $e);
            }
        });
    })
    ->create();
