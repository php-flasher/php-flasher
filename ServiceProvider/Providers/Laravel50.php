<?php

namespace Flasher\Laravel\ServiceProvider\Providers;

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Blade;

final class Laravel50 extends Laravel
{
    public function shouldBeUsed()
    {
        return $this->app instanceof Application && 0 === strpos(Application::VERSION, '5.0');
    }

    public function registerBladeDirectives()
    {
        Blade::extend(function ($view, $compiler) {
            $pattern = $compiler->createPlainMatcher('flasher_render(.*)');

            return preg_replace($pattern, "$1<?php echo app('flasher.renderer')->render($2, 'html'); ?>", $view);
        });
    }
}
