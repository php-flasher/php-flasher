<?php

namespace Flasher\Laravel\ServiceProvider\Providers;

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Blade;
use Flasher\Laravel\Config\Config;
use Flasher\LaravelFlasher\PrimeServiceProvider;
use Flasher\Prime\Middleware\MiddlewareManager;

final class Laravel4 extends Laravel
{
    public function shouldBeUsed()
    {
        return $this->app instanceof Application && 0 === strpos(Application::VERSION, '4.');
    }

    public function publishConfig(NotifyServiceProvider $provider)
    {
        $provider->package('php-flasher/flasher-laravel', 'notify', __DIR__.'/../../../resources');
    }

    public function publishAssets(NotifyServiceProvider $provider)
    {
    }

    public function registerNotifyServices()
    {
        $this->app->singleton('notify.config', function (Application $app) {
            return new Config($app['config'], '::');
        });

        $this->registerCommonServices();
    }

    public function registerBladeDirectives()
    {
        Blade::extend(function ($view, $compiler) {
            $pattern = $compiler->createPlainMatcher('notify_render(.*)');

            return preg_replace($pattern, '$1<?php echo app(\'notify.presenter.html\')->render($2); ?>', $view);
        });
    }
}
