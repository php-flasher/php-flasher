<?php

namespace Flasher\Laravel\ServiceProvider\Providers;

use Flasher\Laravel\FlasherServiceProvider;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Blade;
use Flasher\Laravel\Config\Config;

final class Laravel4 extends Laravel
{
    public function shouldBeUsed()
    {
        return $this->app instanceof Application && 0 === strpos(Application::VERSION, '4.');
    }

    public function publishConfig(FlasherServiceProvider $provider)
    {
        $provider->package('php-flasher/flasher-laravel', 'notify', __DIR__.'/../../../resources');
    }

    public function publishAssets(FlasherServiceProvider $provider)
    {
    }

    public function registerServices()
    {
        $this->app->singleton('flasher.config', function (Application $app) {
            return new Config($app['config'], '::');
        });

        $this->registerCommonServices();
    }

    public function registerBladeDirectives()
    {
        Blade::extend(function ($view, $compiler) {
            $pattern = $compiler->createPlainMatcher('flasher_render(.*)');

            return preg_replace($pattern, '$1<?php echo app(\'flasher.presenter.html\')->render($2); ?>', $view);
        });
    }
}
