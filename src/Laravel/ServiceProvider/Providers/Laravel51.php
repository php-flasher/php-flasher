<?php

namespace Flasher\Laravel\ServiceProvider\Providers;

use Flasher\Laravel\FlasherServiceProvider;
use Illuminate\Foundation\Application;

final class Laravel51 extends Laravel
{
    public function shouldBeUsed()
    {
        return $this->app instanceof Application && 0 === strpos(Application::VERSION, '5.1');
    }

    public function boot(FlasherServiceProvider $provider)
    {
        $provider->publishes(array(
            flasher_path(__DIR__ . '/../../Resources/lang') => base_path(flasher_path('resources/lang/vendor/flasher')),
        ));

        $this->registerBladeDirectives();
        $this->bootServices($this->app);
    }
}
