<?php

namespace Flasher\SweetAlert\Laravel\ServiceProvider\Providers;

use Flasher\SweetAlert\Laravel\FlasherSweetAlertServiceProvider;

interface ServiceProviderInterface
{
    /**
     * @return bool
     */
    public function shouldBeUsed();

    /**
     * @param FlasherSweetAlertServiceProvider $provider
     */
    public function boot(FlasherSweetAlertServiceProvider $provider);

    /**
     * @param FlasherSweetAlertServiceProvider $provider
     */
    public function register(FlasherSweetAlertServiceProvider $provider);
}
