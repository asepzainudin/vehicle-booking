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
