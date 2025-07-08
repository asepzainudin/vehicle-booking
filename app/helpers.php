<?php

use App\Contracts\Tenant\UsingTenant;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Contracts\Pagination;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Fluent;
use Illuminate\Support\Str;
use Illuminate\Support\ViewErrorBag;

if (!function_exists('user')) {
    /**
     * @param string|null $guard
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    function user(string|null $guard = null): \Illuminate\Contracts\Auth\Authenticatable|null
    {
        return auth($guard)->check()
            ? auth($guard)->user()
            : null;
    }
}

if (!function_exists('disguiseText')) {
    /**
     * @param string|int|float $plain
     * @return string
     */
    function disguiseText(string|int|float $plain): string
    {
        $disguiseText = $plain;
        if (! is_string($plain)) {
            $disguiseText = (string) $plain;
        }

        if (config('koffinate.view.obscure.enable', false)) {
            $disguise = config('koffinate.view.obscure.text', '*****');
            if (strlen($disguiseText) <= strlen($disguise)) {
                $disguiseText = $disguise;
            } else {
                $disguiseText = preg_replace(
                    /** @lang text */
                    '/^(\+?\w{3})(\N+)(\w{2})$/',
                    '$1' . $disguise . '$3',
                    $disguiseText
                );
            }
        }
        return $disguiseText;
    }
}

if (!function_exists('f')) {
    /**
     * @param string $text
     * @return string
     */
    function f(string $text = ''): string
    {
        return stripslashes(nl2br($text));
    }
}

if (!function_exists('prettySize')) {
    /**
     * Human-readable file size.
     *
     * @param int $bytes
     * @param int $decimals
     *
     * @return string
     */
    function prettySize(int $bytes, int $decimals = 2): string
    {
        $sz = 'BKMGTPE';
        $factor = (int)floor((strlen($bytes) - 1) / 3);

        return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . $sz[$factor];
    }
}

if (!function_exists('setDefaultRequest')) {
    /**
     * Set Default Value for Request Input.
     *
     * @param string|array $name
     * @param null $value
     * @param bool $force
     *
     * @return void
     * @throws Throwable
     */
    function setDefaultRequest(string|array $name, mixed $value = null, bool $force = true): void
    {
        $request = app('request');
        if (session()->previousUrl() != $request->getUri() || empty(session()->get('_flash.old', []))) {
            try {
                $data = is_array($name) ? $name : array_merge(session()->getOldInput(), [$name => $value]);

                session()->flashInput($data);
                $force ? $request->merge($data) : $request->mergeIfMissing($data);
            } catch (Exception $e) {
                throw_if(app()->hasDebugModeEnabled(), $e);
            }
        }
    }
}

if (!function_exists('fromResource')) {
    /**
     * Generate a collection from resource.
     *
     * @param JsonResource $resource
     *
     * @return mixed
     */
    function fromResource(JsonResource $resource): mixed
    {
        return json_decode(json_encode($resource));
    }
}

if (!function_exists('vendor')) {
    /**
     * Generate an asset path for the application.
     *
     * @param string $path
     *
     * @return string
     */
    function vendor(string $path): string
    {
        $vendorPath = config('koffinate.core.url.vendor');
        $vendorPath = $vendorPath !== '' ? $vendorPath : cachedAsset('vendor');

        if (preg_match('/(:\/\/)+/i', $path, $matches, PREG_UNMATCHED_AS_NULL, 1)) {
            $replacedCount = 0;
            $pattern = '/^(vendor:\/\/)/i';
            $path = preg_replace($pattern, '', $path, -1, $replacedCount);
            if ($replacedCount > 0) {
                $vendorPath .= '/assets';
            }

            $replacedCount = 0;
            $pattern = '/^(asset:\/\/)/i';
            $path = preg_replace($pattern, '', $path, -1, $replacedCount);
            if ($replacedCount > 0) {
                $vendorPath = cachedAsset('');
            }
        }

        if (isDev() && preg_match('/(app)((\.min)?\.css)$/i', $path)) {
            $path = preg_replace('/(app)((\.min)?\.css)$/i', '$1-dev$2', $path);
        }

        return $vendorPath . '/' . $path;
    }
}

if (!function_exists('document')) {
    /**
     * Generate an asset path for the application.
     *
     * @param string $path
     *
     * @return string
     */
    function document(string $path): string
    {
        return config('koffinate.core.url.document', asset('files')) . "/{$path}";
    }
}

if (!function_exists('plugins')) {
    /**
     * Retrive Application Plugins.
     * retriving from config's definitions.
     *
     * @param string|array|null $name
     * @param string $base
     * @param string|array $type
     *
     * @return void
     */
    function plugins(string|array|null $name = null, string $base = 'local', string|array $type = ['css', 'js']): void
    {
        if (!$name) {
            return;
        }
        if (!in_array($base, ['vendor', 'local'])) {
            return;
        }

        $name = (array)$name;
        $type = (array)$type;

        $rs = [];

        foreach ($name as $pkgKey => $pkgVal) {
            if (is_array($pkgVal)) {
                $rs = array_merge_recursive(
                    $rs,
                    pluginAssets(names: $pkgKey, base: $base, type: $type)
                );

                foreach ($pkgVal as $pKey => $pVal) {
                    $rs = array_merge_recursive(
                        $rs,
                        pluginAssets(names: $pVal, base: $base, type: $type, parent: $pkgKey . '.' . $pKey . '.')
                    );
                }
            } else {
                $rs = array_merge_recursive(
                    $rs,
                    pluginAssets(names: $pkgVal, base: $base, type: $type)
                );
            }
        }
        $rs = new Fluent($rs);

        $css = $rs->get('css');
        if (is_array($css)) {
            $css = implode('', $css);
        }
        $js = $rs->get('js');
        if (is_array($js)) {
            $js = implode('', $js);
        }

        View::share(['pluginCss' => $css ?? '', 'pluginJs' => $js ?? '']);
    }
}

if (!function_exists('pluginAssets')) {
    /**
     * Retrive Application Plugins's Assets.
     * retriving from config's definitions.
     *
     * @param array|string $names
     * @param string $base
     * @param array $type
     * @param string $parent
     *
     * @return array
     */
    function pluginAssets(
        array|string $names,
        string $base = 'local',
        array  $type = ['css', 'js'],
        string $parent = '',
    ): array
    {
        if (! is_array($names)) {
            $names = (array) $names;
        }

        $localPath = preg_replace('/\/+$/', '', config('koffinate.plugins.base_path', 'plugins')) . '/';
        $package = "koffinate.plugins.items.{$parent}";
        $httpPattern = '/^(http[s?]:)/i';
        $jsType = config('koffinate.plugins.script_type');
        if (!empty($jsType)) {
            $jsType = "type='{$jsType}' ";
        }

        $rs = [];
        foreach ($names as $name) {
            foreach ($type as $t) {
                $rs[$t] = '';
                if (config()->has("{$package}{$name}.{$t}")) {
                    $legacyCondition = null;
                    if ($t === 'legacy') {
                        $legacyCondition = config("{$package}{$name}.legacy")['condition'];
                        $rs[$t] .= $legacyCondition[0];
                    }

                    foreach (config("{$package}{$name}.{$t}") as $file) {
                        if (preg_match($httpPattern, $file)) {
                            $src = $file;
                        } else {
                            $src = match ($base) {
                                'vendor' => vendor($file),
                                'local' => cachedAsset($localPath . $file),
                                default => null,
                            };
                        }

                        if ($src) {
                            if ($t === 'css') {
                                $rs[$t] .= "<link href='{$src}' rel='stylesheet'>";
                            }
                            if ($t === 'js') {
                                $rs[$t] .= "<script {$jsType}src='{$src}'></script>";
                            }
                        }

                        unset($src);
                    }

                    if ($legacyCondition) {
                        $rs[$t] .= $legacyCondition[1];
                    }
                }
            }
        }

        return $rs;
    }
}

if (!function_exists('trimAll')) {
    /**
     * @param null|string $string
     * @param string $type
     * @param string $pattern
     *
     * @return string
     *
     * @throws Exception
     */
    function trimAll(?string $string, string $type = 'smart', string $pattern = '\W+'): string
    {
        if (!$string || trim($string) == '') {
            return '';
        }
        if (!in_array($type, ['smart', 'both', 'left', 'right', 'all'])) {
            throw new Exception('type of trim not valid, use smart|left|right|all instead.', 401);
        }

        try {
            return match ($type) {
                'both' => preg_replace('/^' . $pattern . '|' . $pattern . '$/i', '', $string),
                'left' => preg_replace('/^' . $pattern . '/i', '', $string),
                'right' => preg_replace('/' . $pattern . '$/i', '', $string),
                'all' => preg_replace('/' . $pattern . '/i', '', $string),
                default => preg_replace('/' . $pattern . '/i', ' ',
                    preg_replace('/^' . $pattern . '|' . $pattern . '$/i', '', $string)),
            };
        } catch (Exception $e) {
        }

        return '';
    }
}

if (!function_exists('carbon')) {
    /**
     * @param string|DateTimeInterface|null $datetime
     * @param DateTimeZone|string|null $timezone
     * @param string $locale
     *
     * @return Carbon
     */
    function carbon(
        string|DateTimeInterface|null $datetime = null,
        string|DateTimeZone|null      $timezone = null,
        string                        $locale = 'id_ID',
    ): Carbon
    {
        if (auth()->check()) {
            if (!$timezone && (auth()->user()?->timezone ?? null)) {
                $timezone = auth()->user()->timezone;
            }
            if (!$locale && (auth()->user()?->locale ?? null)) {
                $locale = auth()->user()->locale;
            }
        }

        try {
            Carbon::setLocale($locale);
        } catch (Exception $e) {
            //
        }

        if (!$datetime) {
            return Carbon::now()->timezone($timezone);
        }

        return Carbon::parse($datetime)->timezone($timezone);
    }
}

if (!function_exists('carbonFormat')) {
    /**
     * @param string|DateTimeInterface|null $datetime
     * @param string $isoFormat
     * @param string|null $format
     * @param string|DateTimeZone|null $timezone
     * @param bool $showTz
     *
     * @return string
     */
    function carbonFormat(
        string|DateTimeInterface|null $datetime,
        string                        $isoFormat = 'L LT',
        string|null                   $format = null,
        string|DateTimeZone|null      $timezone = null,
        bool                          $showTz = true,
    ): string
    {
        $timezone ??= '+07:00';
        $timezoneSuffix = match (str($timezone)->slug()->toString()) {
            '7',    // +7
            '70',   // +7:0
            '700',  // +7:00
            '0700',
            'asiajakarta' => 'WIB',
            '8',    // +8
            '80',   // +8:0
            '800',  // +8:00
            '0800',
            'asiamakassar' => 'WITA',
            '9',    // +9
            '90',   // +9:0
            '900',  // +9:00
            '0900',
            'asiajayapura' => 'WIT',
            default => $timezone,
        };

        if (is_null($datetime)) {
            return '';
        }

        if (is_string($datetime)) {
            try {
                $datetime = Carbon::parse($datetime);
            } catch (Exception $e) {
                return '';
            }
        }

        $datetime->timezone($timezone);
        $timezoneLabel = $showTz && $timezoneSuffix
            ? " {$timezoneSuffix}"
            : '';

        if ($format) {
            return "{$datetime->format($format)}{$timezoneLabel}";
        }

        return "{$datetime->isoFormat($isoFormat)}{$timezoneLabel}";
    }
}

if (!function_exists('numberFormat')) {
    /**
     * @param  float|int|null  $number
     * @param  int  $decimal
     *
     * @return string
     */
    function numberFormat(float|int|null $number = null, int $decimal = 0): string
    {
        if (! $number) {
            return '0';
        }
        return number_format($number, $decimal, ',', '.');
    }
}

if (!function_exists('toSentry')) {
    /**
     * @param Throwable $throw
     *
     * @return void
     */
    function toSentry(Throwable $throw): void
    {
        if (app()->bound('sentry') && !app()->isLocal()) {
            \Sentry\Laravel\Integration::captureUnhandledException($throw);
        }
    }
}

if (!function_exists('isDev')) {
    /**
     * Development Mode Checker.
     *
     * @return bool
     */
    function isDev(): bool
    {
        if (Session::has('dev_mode')) {
            return Session::get('dev_mode', false);
        }

        $dev = (string)env('APP_DEV_MODE', 'off');

        return in_array(strtolower($dev), ['true', '1', 'on']);
    }
}

if (!function_exists('hasRoute')) {
    /**
     * Existing Route by Name.
     *
     * @param string $name
     *
     * @return bool
     */
    function hasRoute(string $name): bool
    {
        return app('router')->has($name);
    }
}

if (!function_exists('routed')) {
    /**
     * Existing Route by Name
     * with '#' fallback.
     *
     * @param string $name
     * @param string|array $params
     * @param bool $absolute
     *
     * @return string
     */
    function routed(string $name, string|array $params = [], bool $absolute = true): string
    {
        if (app('router')->has($name)) {
            return app('url')->route($name, $params, $absolute);
        }

        return '#';
    }
}

if (!function_exists('activeRoute')) {
    /**
     * @param string $route
     * @param string|array $params
     *
     * @return bool
     */
    function activeRoute(string $route = '', string|array $params = []): bool
    {
        if (empty($route = trim($route))) {
            return false;
        }

        try {
            if (request()->routeIs($route, "{$route}.*")) {
                if (empty($params)) {
                    return true;
                }

                $requestRoute = request()->route();
                $paramNames = $requestRoute->parameterNames();

                foreach ($params as $key => $value) {
                    if (is_int($key)) {
                        $key = $paramNames[$key];
                    }

                    if (
                        $requestRoute->parameter($key) instanceof Model
                        && $value instanceof Model
                        && $requestRoute->parameter($key)->id != $value->id
                    ) {
                        return false;
                    }

                    if (is_object($requestRoute->parameter($key))) {
                        // try to check param is enum type
                        try {
                            if ($requestRoute->parameter($key)->value && $requestRoute->parameter($key)->value != $value) {
                                return false;
                            }
                        } catch (Exception $e) {
                            return false;
                        }
                    } else {
                        if ($requestRoute->parameter($key) != $value) {
                            return false;
                        }
                    }
                }

                return true;
            }
        } catch (Exception $e) {
        }

        return false;
    }
}

if (!function_exists('activeCss')) {
    /**
     * @param string $route
     * @param array $params
     * @param string $cssClass
     *
     * @return string
     */
    function activeCss(string $route = '', array $params = [], string $cssClass = 'active current'): string
    {
        return activeRoute($route, $params) ? $cssClass : '';
    }
}

if (!function_exists('getRawSql')) {
    /**
     * @param \Illuminate\Contracts\Database\Eloquent\Builder|Builder $query
     *
     * @return string
     */
    function getRawSql(
        \Illuminate\Contracts\Database\Eloquent\Builder|Builder $query,
    ): string
    {
        return Str::replaceArray('?', $query->getBindings(), $query->toSql());
    }
}

if (!function_exists('getErrors')) {
    /**
     * Get validation errors.
     *
     * @param string|null $bag
     *
     * @return ViewErrorBag|null
     */
    function getErrors(?string $bag = null): ?ViewErrorBag
    {
        $errors = session('errors');
        if (!$errors instanceof ViewErrorBag) {
            return null;
        }
        if ($bag) {
            if (empty($errors->{$bag}->all())) {
                return null;
            }
            $errors = $errors->$bag;
        }

        return $errors;
    }
}

if (!function_exists('hasError')) {
    /**
     * Exist validation error.
     *
     * @param string|array|null $key
     * @param string|null $bag
     *
     * @return bool
     */
    function hasError(string|array|null $key = null, ?string $bag = null): bool
    {
        if (($errors = getErrors($bag)) instanceof ViewErrorBag === false) {
            return false;
        }

        return $errors->has($key);
    }
}

if (!function_exists('inputFeedbackComponent')) {
    /**
     * Input feedback component
     *
     * @param string|array $message
     * @param string $mode valid|invalid
     * @param string $type feedback|tooltip
     * @param string $glue
     * @param string|null $id
     *
     * @return Htmlable
     */
    function inputFeedbackComponent(
        string|array $message,
        string $mode = 'invalid',
        string $type = 'feedback',
        string $glue = '<br>',
        string|null $id = null
    ): Htmlable {
        if (!in_array($mode, ['valid', 'invalid'])) {
            $mode = 'invalid';
        }
        if (!in_array($type, ['feedback', 'tooltip'])) {
            $type = 'feedback';
        }
        if (is_array($message)) {
            $message = implode($glue, $message);
        }

        return str("<div class='{$mode}-{$type}' id='{$id}'>{$message}</div>")->toHtmlString();
    }
}

if (!function_exists('feedbackClass')) {
    /**
     * Feedback CSS Class
     *
     * @param string|array|null $key
     * @param string|null $bag
     * @param bool $isGroup
     * @param string|null $class
     *
     * @return string
     */
    function feedbackClass(
        string|array|null $key = null,
        string|null $bag = null,
        bool $isGroup = false,
        string|null $class = null
    ): string {
        if (hasError($key, $bag)) {
            return $class ?? ($isGroup ? 'has-error' : 'is-invalid');
        }
        return '';
    }
}

if (!function_exists('feedbackInput')) {
    /**
     * InValid input feedback
     *
     * @param string|array|null $key
     * @param ?string $bag
     * @param string $type feedback|tooltip
     * @param bool $asString
     * @return Htmlable|string
     */
    function feedbackInput(
        string|array|null $key = null,
        string|null $bag = null,
        string $type = 'feedback',
        bool $asString = false
    ): Htmlable|string {
        if (empty($errors = getErrors($bag))) return '';

        if (is_array($key)) {
            $messages = [];
            foreach ($key as $k) {
                if ($errors->has($k)) {
                    $messages[] = $errors->first($k);
                }
            }
        } else {
            $messages = $errors->first($key);
        }

        return empty($messages) ? '' : inputFeedbackComponent($messages, 'invalid', $type);
    }
}

if (!function_exists('errorAll')) {
    /**
     * InValid input feedback
     *
     * @param string|null $bag
     * @param array|null $excludeKey
     * @return string
     */
    function errorAll(string $bag = null, array $excludeKey = null): string
    {
        $errors = session('errors');
        if (empty($errors)) return '';
        if ($bag) {
            if (empty($errors->$bag->all())) return '';
            // $errors = $errors->$bag;
        }
        // if (!$errors->has($key)) return '';

        return '<div class="alert alert-danger rounded-0" style="border-width: 2px; border-left: none; border-right: none;">' .
            '<h4 class="alert-heading">Eror!! <small>Periksa Lagi Inputan Anda</small></h4>' .
            '</div>';
    }
}

if (!function_exists('viewPath')) {
    /**
     * Compile view path.
     *
     * @param string|null $path
     *
     * @return string
     */
    function viewPath(string|null $path = null): string
    {
        $path = $path ?? '';

        try {
            $view = view()->shared('viewPath', '');

            return $view . $path;
        } catch (Exception $e) {
            return $path;
        }
    }
}

if (!function_exists('isPaginated')) {
    /**
     * Check data is paginated.
     *
     * @param Arrayable $source
     *
     * @return bool
     */
    function isPaginated(Arrayable $source): bool
    {
        try {
            return (
                $source instanceof Pagination\Paginator ||
                $source instanceof Pagination\CursorPaginator
            );
        } catch (Exception $e) {
            return false;
        }
    }
}

if (!function_exists('paginatedStyleReset')) {
    /**
     * Style reset paginate.
     *
     * @param Arrayable $source
     *
     * @return string
     */
    function paginatedStyleReset(Arrayable $source): string
    {
        try {
            if (!isPaginated($source)) {
                throw new Exception('invalid data type');
            }

            $numReset = $source->perPage() * ($source->currentPage() - 1);

            return "counter-reset: _rownum {$numReset};";
        } catch (Exception $e) {
            return '';
        }
    }
}

if (!function_exists('paginatedLink')) {
    /**
     * Generate paginate links.
     *
     * @param Arrayable $source
     * @param string|null $view
     * @param array $data
     *
     * @return Htmlable
     */
    function paginatedLink(
        Arrayable $source,
        string|null       $view = null,
        array             $data = [],
    ): Htmlable
    {
        try {
            if (!isPaginated($source)) {
                throw new Exception('invalid data type');
            }

            return $source->links($view, $data);
        } catch (Exception $e) {
            return str()->toHtmlString();
        }
    }
}

if (!function_exists('cachedAsset')) {
    /**
     * @param string $path
     * @param bool $secure
     *
     * @return string
     */
    function cachedAsset(string $path, bool|null $secure = null): string
    {
        $asset = str($path)->is('/^https?:\/\//i')
            ? $path
            : asset($path, $secure);

        return $asset . '?_v=' . config('cache.version', time());
    }
}

if (!function_exists('cacheCode')) {
    /**
     * @param  int|string|null  $tenantId
     *
     * @return mixed
     */
    function cacheCode(int|string|null $tenantId = null): string
    {
        return app('cache_code', compact('tenantId'));
    }
}

if (!function_exists('cacheName')) {
    /**
     * @param  string  $name
     * @param  bool  $lock
     * @param  int|string|null  $tenantId
     *
     * @return mixed
     */
    function cacheName(string $name, true|null $lock = null, int|string|null $tenantId = null): string
    {
        return app('cache_name', compact('name', 'lock', 'tenantId'));
    }
}

if (!function_exists('authTenant')) {
    /**
     * @return UsingTenant|null
     */
    function authTenant(): UsingTenant|null
    {
        return app('auth_tenant');
    }
}

if (!function_exists('authTenantId')) {
    /**
     * @return int|null
     */
    function authTenantId(): int|null
    {
        return app('auth_tenant_id');
    }
}

if (!function_exists('allowNullTenant')) {
    /**
     * @param  mixed  $model
     * @param  bool  $allow
     *
     * @return bool
     */
    function allowNullTenant(mixed $model, bool $allow = false): bool
    {
        if (
            ! $allow &&
            authTenantId() &&
            $model instanceof \App\Contracts\Tenant\HasTenant
        ) {
            $key = $model::tenantKey();
            return !empty($model->$key);
        }
        return true;
    }
}

if (!function_exists('abortNullTenant')) {
    /**
     * @param  mixed  $model
     * @param  bool  $abort
     *
     * @return void
     */
    function abortNullTenant(mixed $model, bool $abort = true): void
    {
        if ($abort) {
            abort_if(! allowNullTenant($model), 404);
        }
    }
}

if (!function_exists('setting')) {
    /**
     * @param  string|null  $key
     * @param  int|string|null  $tenantId
     *
     * @return Collection<Fluent>|Fluent
     */
    function setting(
        string|null $key = null,
        int|string|null $tenantId = null
    ): Collection|Fluent {
        if (! $tenantId) {
            $tenantId = authTenantId();
        }

        if ($tenantId) {
            try {
                if (is_string($tenantId)) {
                    $tenantId = \App\Models\Tenant\Tenant::hashToId($tenantId);
                }
                $name = cacheName("setting:{$tenantId}:{$key}", tenantId: $tenantId);
                return app('cache')->store('file')->remember($name, now()->endOfDay(), function () use ($key, $tenantId) {
                    return app('setting', compact('key', 'tenantId'));
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
     * @param  int|string|null  $tenantId
     *
     * @return bool
     */
    function settingReset(
        string|null $key = null,
        int|string|null $tenantId = null
    ): bool {
        if (! $tenantId) {
            $tenantId = authTenantId();
        }
        if ($tenantId) {
            $name = cacheName("setting:{$tenantId}:{$key}", tenantId: $tenantId);
            return app('cache')->store('file')->forget($name);
        }
        return false;
    }
}

if (!function_exists('hasStack')) {
    /**
     * @param  string|null  $name
     *
     * @return bool
     */
    function hasStack(string|null $name = null): bool
    {
        return $name && !empty(view()->yieldPushContent($name));
    }
}

if (!function_exists('isButtonClass')) {
    function isButtonClass(string|null $class = null): bool
    {
        return (bool) preg_match('/btn-(\w+-)?(primary|secondary|success|info|warning|danger|light|dark|link)/i', $class);
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
