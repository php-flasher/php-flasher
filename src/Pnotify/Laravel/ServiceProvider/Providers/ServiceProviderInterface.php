<?php

namespace Flasher\Pnotify\Laravel\ServiceProvider\Providers;

use Flasher\Pnotify\Laravel\FlasherPnotifyServiceProvider;

interface ServiceProviderInterface
{
    /**
     * @return bool
     */
    public function shouldBeUsed();

    /**
     * @param FlasherPnotifyServiceProvider $provider
     */
    public function boot(FlasherPnotifyServiceProvider $provider);

    /**
     * @param FlasherPnotifyServiceProvider $provider
     */
    public function register(FlasherPnotifyServiceProvider $provider);
}
