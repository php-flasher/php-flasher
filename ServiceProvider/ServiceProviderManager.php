<?php

namespace Flasher\Toastr\Laravel\ServiceProvider;

use Flasher\Toastr\Laravel\NotifyToastrServiceProvider;
use Flasher\Toastr\Laravel\ServiceProvider\Providers\ServiceProviderInterface;

final class ServiceProviderManager
{
    private $provider;

    /**
     * @var ServiceProviderInterface[]
     */
    private $providers = array(
        'Flasher\Toastr\Laravel\ServiceProvider\Providers\Laravel4',
        'Flasher\Toastr\Laravel\ServiceProvider\Providers\Laravel',
        'Flasher\Toastr\Laravel\ServiceProvider\Providers\Lumen',
    );

    private $notifyServiceProvider;

    public function __construct(NotifyToastrServiceProvider $notifyServiceProvider)
    {
        $this->notifyServiceProvider = $notifyServiceProvider;
    }

    public function boot()
    {
        $provider = $this->resolveServiceProvider();

        $provider->publishConfig($this->notifyServiceProvider);
        $provider->mergeConfigFromToastr();
    }

    public function register()
    {
        $provider = $this->resolveServiceProvider();
        $provider->registerNotifyToastrServices();
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
