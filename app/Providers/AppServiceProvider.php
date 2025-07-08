<?php

namespace App\Providers;

use App\Contracts\Partner\UsingPartner;
use App\Core\KTBootstrap;
use App\Models\Base\Setting;
use App\Models\Partner\Partner;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Fluent;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->singleton('request_id', fn (): string => uniqid('req::'));
        $this->app->singleton('notifLog', fn() => app('log')->channel('msnotif'));
        $this->app->singleton('cache_code', function ($app, $param): string {
            $partnerId = $param['partnerId'] ?? authPartnerId();
            return app('cache')->remember('cch_code:' . $partnerId, now()->endOfMonth(), fn () => uniqid());
        });
        $this->app->singleton('cache_name', function (Application $app, $param): string {
            $partnerId = $param['partnerId'] ?? authPartnerId();
            return app('cache')->remember('cch_name:' . $partnerId, now()->endOfDay(), function () use ($partnerId, $param) {
                $param['name'] ??= str(config('app.name'))->slug()->toString();
                $param['lock'] ??= false;
                $names = explode(':', $param['name'], 2);
                $param['name'] = $names[0] . ':' . $partnerId . (empty($names[1]) ? '' : ':' . $names[1]);

                return $param['name'] .':'. app('cache_code', compact('partnerId')) . ($param['lock'] ? ':locked' : '');
            });
        });
        $this->app->singleton('auth_partner', function (): UsingPartner|null {
            return Partner::cleanQuery()
                ->where('id', session('partner_id'))
                ->first();
        });
        $this->app->singleton('auth_partner_id', fn (): int|null => session('partner_id'));
        $this->app->singleton('setting', function (Application $app, $param): Collection|Fluent {
            $param['key'] ??= null;
            $param['partnerId'] ??= null;
            if (! $param['partnerId']) {
                return new Fluent();
            }

            $query = \App\Models\Base\Setting::query()
                ->select('type', 'key', 'value', 'value_type', 'complex')
                // ->selectRaw("(case when \"value_type\" = 'boolean' then \"value\" = 'true' when \"value_type\" in ('int', 'integer') then \"value\"::int else \"value\" end) as \"value\"")
                ->useTenant($param['partnerId']);
            if ($param['key']) {
                return Setting::mapSetting(
                    $query->where('key', $param['key'])
                        ->orderBy(Setting::partnerKey(), 'asc')
                        ->first()
                );
            }
            return $query->get()->mapWithKeys(fn ($it) => [$it->key => Setting::mapSetting($it)]);
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        // Update defaultStringLength
        // Builder::defaultStringLength(191);
        if (config('app.secure', false)) {
            $this->app['request']->server->set('HTTPS', true);
            URL::forceScheme('https');
        }

        // $this->events();

        // $this->views();
        // $this->blades();

        KTBootstrap::init();
    }

    private function events(): void
    {
        Event::listen([
            'App\Core\Notification\Events\NotifyCreated' => [
                'App\Core\Notification\Listeners\NotifyOnCreated',
            ],
            'App\Core\Notification\Events\NotifySent' => [
                'App\Core\Notification\Listeners\NotifyOnSent',
            ],
        ]);
    }

    private function views(): void
    {
        $this->loadViewsFrom(base_path('modules/ms_old/resources/views'), 'msold');
        Blade::componentNamespace('App\\MsOld\\View\\Components', 'msold');

        // Livewire::component('msold.views.components.msold', 'msoldViewComponent');
    }

    private function blades(): void
    {
        Blade::if('hasSections', function (string ...$sections) {
            $view = app('view');
            foreach ($sections as $section) {
                // $sectionKey = "yieldContent{$section}";
                if (!empty(trim($view->yieldContent($section)))) {
                    return true;
                }
            }
            return false;
        });

        Blade::if('hasStack', function($stackName) {
            return hasStack($stackName);
        });

        Blade::directive('feedback', function ($args) {
            return "<?php echo feedbackInput({$args});?>";
        });

        Blade::directive('feedbackClass', function ($args) {
            return "<?php echo feedbackClass({$args});?>";
        });

        Blade::directive('plugins', function ($arguments) {
            return "<?php plugins([{$arguments}]); ?>";
        });

        Blade::directive('method_if', function ($arguments) {
            $arguments = explode(',', $arguments, 3);
            $condition = $arguments[0] ?? '';
            $method = $arguments[1] ?? '';
            return "<?= {$condition} ? method_field({$method}) : ''; ?>";
        });
    }

    /**
     * @param  Setting|null  $setting
     *
     * @return Fluent
     */
    private function mapSetting(Setting|null $setting): Fluent
    {
        $mappedSetting = [];
        if ($setting instanceof Setting) {
            $value = match ($setting->value_type) {
                'bool',
                'boolean' => $setting->value == 'true',
                'int',
                'integer' => (int) $setting->value,
                default => $setting->value,
            };

            $mappedSetting = Arr::dot([
                'type' => $setting->type,
                'value' => $value,
                'complex' => $setting->complex,
            ]);
        }

        return new Fluent($mappedSetting);
    }
}
