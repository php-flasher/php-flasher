<?php

namespace Flasher\Pnotify\Laravel\ServiceProvider\Providers;

use Flasher\Pnotify\Laravel\FlasherPnotifyServiceProvider;

interface ServiceProviderInterface
{
    /**
     * @return bool
     */
    public function shouldBeUsed();

    public function boot(FlasherPnotifyServiceProvider $provider);

    public function register(FlasherPnotifyServiceProvider $provider);
}
