<?php

namespace Flasher\Laravel\ServiceProvider\Providers;

use Flasher\Laravel\Config\Config;
use Flasher\Laravel\FlasherServiceProvider;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Blade;
use Illuminate\View\Compilers\BladeCompiler;

final class Laravel4 extends Laravel
{
    /**
     * @inheritDoc
     */
    public function shouldBeUsed()
    {
        return $this->app instanceof Application && 0 === strpos(Application::VERSION, '4.');
    }

    /**
     * @inheritDoc
     */
    public function boot(FlasherServiceProvider $provider)
    {
        $provider->package('php-flasher/flasher-laravel', 'flasher', flasher_path(__DIR__.'/../../Resources'));

        $this->registerBladeDirectives();
    }

    /**
     * @inheritDoc
     */
    public function register(FlasherServiceProvider $provider)
    {
        $this->app->singleton('flasher.config', function (Application $app) {
            return new Config($app['config'], '::');
        });

        $this->registerCommonServices();
    }

    protected function registerBladeDirectives()
    {
        $startsWith = function($haystack, $needle) {
            return substr_compare($haystack, $needle, 0, strlen($needle)) === 0;
        };

        $endsWith = function($haystack, $needle) {
            return substr_compare($haystack, $needle, -strlen($needle)) === 0;
        };

        Blade::extend(function ($view, BladeCompiler $compiler) use ($startsWith, $endsWith) {
            $pattern = $compiler->createPlainMatcher('flasher_render(.*)');
            $matches = array();

            preg_match($pattern, $view, $matches);

            $value = $matches[2];

            if (!empty($value) && $startsWith($value, "(") && $endsWith($value, ")")) {
                $value = substr($value, 1, -1);
            }

            if (empty($value)) {
                $value = "array()";
            }

            return str_replace("%criteria%", $value, $matches[1] . "<?php echo app('flasher.response_manager')->render(%criteria%, 'html'); ?>");
        });
    }
}
