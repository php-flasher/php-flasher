<?php

namespace Flasher\Laravel\ServiceProvider\Providers;

use Flasher\Laravel\FlasherServiceProvider;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Blade;
use Illuminate\View\Compilers\BladeCompiler;

final class Laravel50 extends Laravel
{
    public function shouldBeUsed()
    {
        return $this->app instanceof Application && 0 === strpos(Application::VERSION, '5.0');
    }

    public function boot(FlasherServiceProvider $provider)
    {
        $provider->publishes(array(
            flasher_path(__DIR__ . '/../../Resources/lang') => base_path(flasher_path('resources/lang/vendor/flasher')),
        ));

        $this->registerBladeDirectives();
        $this->bootServices($this->app);
    }

    /**
     * @return void
     */
    protected function registerBladeDirectives()
    {
        $startsWith = function ($haystack, $needle) {
            return substr_compare($haystack, $needle, 0, strlen($needle)) === 0;
        };

        $endsWith = function ($haystack, $needle) {
            return substr_compare($haystack, $needle, -strlen($needle)) === 0;
        };

        Blade::extend(function ($view, BladeCompiler $compiler) use ($startsWith, $endsWith) {
            if (!method_exists($compiler, 'createPlainMatcher')) {
                return '';
            }

            $pattern = $compiler->createPlainMatcher('flasher_render(.*)');
            $matches = array();

            preg_match($pattern, $view, $matches);

            $value = $matches[2];

            if (!empty($value) && $startsWith($value, '(') && $endsWith($value, ')')) {
                $value = substr($value, 1, -1);
            }

            return str_replace(
                '%criteria%',
                $value,
                $matches[1] . "<?php echo app('flasher.response_manager')->render(%criteria%); ?>"
            );
        });
    }
}
