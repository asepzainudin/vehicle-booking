<?php

use App\Contracts\Partner\{HasPartner, UsingPartner};
use App\Core\Notification\NotifyManager;
use App\Enums\Date\Day;
use App\Models\Partner\Partner;
use App\Vendor\DataTables\EloquentDataTable;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Fluent;
use Yajra\DataTables\DataTableAbstract;

if (!function_exists('debugNonProduction')) {
    /**
     * @return bool
     */
    function debugNonProduction(): bool
    {
        return app()->hasDebugModeEnabled() && ! app()->isProduction();
    }
}

if (!function_exists('isAtomicLockSupport')) {
    /**
     * @return bool
     */
    function isAtomicLockSupport(): bool
    {
        return in_array(app('cache')->getDefaultDriver(), [
            'memcached', 'redis', 'dynamodb', 'database', 'file', 'array',
        ]);
    }
}

if (! function_exists('hasRole')) {
    function hasRole(string|\Illuminate\Contracts\Auth\Authenticatable ... $role): bool
    {
        return true;
    }
}

if (! function_exists('hasPermission')) {
    function hasPermission(string|\Illuminate\Contracts\Auth\Authenticatable ... $permission): bool
    {
        return true;
    }
}

if (! function_exists('carbonFromFormat')) {
    /**
     * @param  string  $date
     * @param  string  $format
     *
     * @return Carbon|null
     */
    function carbonFromFormat(string $date, string $format): Carbon|null
    {
        try {
            return Carbon::createFromFormat('Ymd', $date);
        } catch (Exception $e) {
            return null;
        }
    }
}

if (! function_exists('days')) {
    /**
     * @return Day[]
     */
    function days(array|null $except = null): array
    {
        $days = Day::cases();
        if ($except) {
            $days = Arr::where($days, fn ($d) => ! in_array($d->value, $except));
        }

        return $days;
    }
}

if (! function_exists('kfnTableEloquent')) {
    /**
     * @param  Builder  $builder
     *
     * @return DataTableAbstract
     */
    function kfnTableEloquent(
        Builder $builder
    ): DataTableAbstract {
        return new EloquentDataTable($builder);
    }
}

if (!function_exists('clientTimezone')) {
    /**
     * @return mixed
     */
    function clientTimezone(): string
    {
        return config('app.client_timezone');
    }
}

if (!function_exists('msnotif')) {
    /**
     * @param  string  $channel
     * @param  array  $tags
     *
     * @return NotifyManager
     */
    function msnotif(string $channel, int|null $partnerId = null, array $tags = []): NotifyManager
    {
        return new NotifyManager(
            channel: $channel,
            tags: $tags,
            partnerId: $partnerId
        );
    }
}


if (!function_exists('logError')) {
    /**
     * @param string|\Exception $exception
     * @param string|null $title
     * @param string|array|null $data
     *
     * @return void
     */
    function logError(string|Exception $exception, string|null $title = null, string|array|null $data = null): void
    {
        $context = [];
        $title ??= 'ERROR';

        if ($data) {
            $data = json_encode($data, JSON_PRETTY_PRINT);
        }

        if (is_string($exception)) {
            $context['message'] = $exception;
            $context['code'] = '4xx';
            $context['data'] = $data ?? '';
        }

        if ($exception instanceof Exception) {
            try {
                $code = $exception->getStatusCode();
            } catch (Exception $e) {
                $code = $exception->getCode();
            }
            $context['message'] = $exception->getMessage();
            $context['code'] = $code;
            $context['file'] = $exception->getFile();
            $context['line'] = $exception->getLine();
            $context['data'] = $data ?? '';
            $context['trace'] = explode(PHP_EOL, $exception->getTraceAsString());
        }

        app('log')->error("=====#   {$title}   #=====", $context);
    }
}

if (!function_exists('cacheCode')) {
    /**
     * @return mixed
     */
    function cacheCode(): string
    {
        return app('cache_code');
    }
}

if (!function_exists('cacheName')) {
    /**
     * @param  string  $name
     * @param  bool  $lock
     *
     * @return mixed
     */
    function cacheName(string $name, true|null $lock = null): string
    {
        return app('cache_name', compact('name', 'lock'));
    }
}

if (!function_exists('authPartner')) {
    /**
     * @return UsingPartner|null
     */
    function authPartner(): UsingPartner|null
    {
        return app('auth_partner');
    }
}

if (!function_exists('authPartnerId')) {
    /**
     * @return int|null
     */
    function authPartnerId(): int|null
    {
        return app('auth_partner_id');
    }
}

if (!function_exists('allowNullPartner')) {
    /**
     * @param  mixed  $model
     * @param  bool  $allow
     *
     * @return bool
     */
    function allowNullPartner(mixed $model, bool $allow = false): bool
    {
        if (
            ! $allow &&
            authPartnerId() &&
            $model instanceof HasPartner
        ) {
            $key = $model::partnerKey();
            return !empty($model->$key);
        }
        return true;
    }
}

if (!function_exists('abortNullPartner')) {
    /**
     * @param  mixed  $model
     * @param  bool  $abort
     *
     * @return void
     */
    function abortNullPartner(mixed $model, bool $abort = true): void
    {
        if ($abort) {
            abort_if(! allowNullPartner($model), 404);
        }
    }
}

if (!function_exists('setting')) {
    /**
     * @param  string|null  $key
     * @param  int|string|null  $partnerId
     *
     * @return Collection<Fluent>|Fluent
     */
    function setting(
        string|null $key = null,
        int|string|null $partnerId = null
    ): Collection|Fluent {
        if (! $partnerId) {
            $partnerId = authPartnerId();
        }

        if ($partnerId) {
            try {
                if (is_string($partnerId)) {
                    $partnerId = Partner::hashToId($partnerId);
                }
                $name = cacheName("setting:{$partnerId}:{$key}");
                return app('cache')->store('file')->remember($name, now()->endOfDay(), function () use ($key, $partnerId) {
                    return app('setting', compact('key', 'partnerId'));
                });
            } catch (Exception $e) {
                if (app()->hasDebugModeEnabled()) {
                    app('logger')->error($e->getMessage(), [
                        'status' => $e->getCode(),
                        'traces' => explode(PHP_EOL, $e->getTraceAsString()),
                    ]);
                }
            }
        }
        return new Fluent();
    }
}

if (!function_exists('settingReset')) {
    /**
     * @param  string|null  $key
     * @param  int|string|null  $partnerId
     *
     * @return bool
     */
    function settingReset(
        string|null $key = null,
        int|string|null $partnerId = null
    ): bool {
        if (! $partnerId) {
            $partnerId = authPartnerId();
        }
        if ($partnerId) {
            $name = cacheName("setting:{$partnerId}:{$key}");
            return app('cache')->store('file')->forget($name);
        }
        return false;
    }
}

if (!function_exists('isThemeClass')) {
    function isThemeClass(string $prefix = '', string|null $class = null): bool
    {
        return (bool) preg_match('/'.$prefix.'(\w+-)?(primary|secondary|success|info|warning|danger|light|dark|link)/i', $class);
    }
}

if (!function_exists('isButtonClass')) {
    function isButtonClass(string|null $class = null): bool
    {
        return isThemeClass('btn-', $class);
    }
}

if (!function_exists('xIcon')) {
    function xIcon(string $name): string
    {
        $icon = match ($name) {
            'show' => 'fa-eye',
            'edit' => 'fa-pencil',
            'delete' => 'fa-trash-can',
            'reload' => 'fa-rotate',
            'print' => 'fa-print',
            default => null
        };
        return $icon
            ? '<i class="fad fa-fw '.$icon.'"></i>'
            : '';

        // if (view()->exists('components.icon.'.$name)) {
        //     return view('components.icon.'.$name)->render();
        // }
        // return '';
    }
}

if (!function_exists('set_active')) {
    function set_active($route)
    {
        return Route::is($route) ? 'active' : '';
    }
}

if (!function_exists('replace_rupiah')) {
    function replace_rupiah(string $money)
    {
        $money = str_replace('.', '', $money);
        $money = (int) $money;
        return $money;
    }
}
