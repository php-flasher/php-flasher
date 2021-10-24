<?php

namespace Flasher\Laravel\ServiceProvider\Providers;

use Flasher\Laravel\Config\Config;
use Flasher\Laravel\FlasherServiceProvider;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Blade;
use Illuminate\View\Compilers\BladeCompiler;

final class Laravel4 extends Laravel
{
    public function shouldBeUsed()
    {
        return $this->app instanceof Application && 0 === strpos(Application::VERSION, '4.');
    }

    public function boot(FlasherServiceProvider $provider)
    {
        // @phpstan-ignore-next-line
        $provider->package('php-flasher/flasher-laravel', 'flasher', flasher_path(__DIR__ . '/../../Resources'));

        $this->registerBladeDirectives();
        $this->bootServices($this->app);
    }

    public function register(FlasherServiceProvider $provider)
    {
        $this->app->singleton('flasher.config', function (Application $app) {
            return new Config($app['config'], '::');
        });

        $this->registerCommonServices();
    }

    /**
     * @return void
     */
    protected function registerBladeDirectives()
    {
        Blade::extend(function ($view, BladeCompiler $compiler) {
            if (!method_exists($compiler, 'createMatcher')) {
                return '';
            }

            $pattern = $compiler->createMatcher('flasher_render');

            return preg_replace($pattern, '$1<?php echo app(\'flasher.response_manager\')->render$2; ?>', $view);
        });
    }
}
