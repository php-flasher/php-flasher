<?php

namespace Flasher\Toastr\Laravel\ServiceProvider;

use Flasher\Toastr\Laravel\FlasherToastrServiceProvider;
use Flasher\Toastr\Laravel\ServiceProvider\Providers\ServiceProviderInterface;

final class ServiceProviderManager
{
    /**
     * @var ServiceProviderInterface
     */
    private $provider;

    /**
     * @var ServiceProviderInterface[]
     */
    private $providers = array(
        'Flasher\Toastr\Laravel\ServiceProvider\Providers\Laravel4',
        'Flasher\Toastr\Laravel\ServiceProvider\Providers\Laravel',
    );

    /**
     * @var FlasherToastrServiceProvider
     */
    private $notifyServiceProvider;

    public function __construct(FlasherToastrServiceProvider $notifyServiceProvider)
    {
        $this->notifyServiceProvider = $notifyServiceProvider;
    }

    public function boot()
    {
        $provider = $this->resolveServiceProvider();
        $provider->boot($this->notifyServiceProvider);
    }

    public function register()
    {
        $provider = $this->resolveServiceProvider();
        $provider->register($this->notifyServiceProvider);
    }

    /**
     * @return ServiceProviderInterface
     */
    private function resolveServiceProvider()
    {
        if ($this->provider instanceof ServiceProviderInterface) {
            return $this->provider;
        }

        foreach ($this->providers as $providerClass) {
            $provider = new $providerClass($this->notifyServiceProvider->getApplication());

            if ($provider->shouldBeUsed()) {
                return $this->provider = $provider;
            }
        }

        throw new \InvalidArgumentException('Service Provider not found.');
    }
}
