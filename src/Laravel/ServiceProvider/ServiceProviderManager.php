<?php

namespace Flasher\Laravel\ServiceProvider;

use Flasher\Laravel\FlasherServiceProvider;
use Flasher\Laravel\ServiceProvider\Providers\ServiceProviderInterface;

final class ServiceProviderManager
{
    private $provider;

    /**
     * @var ServiceProviderInterface[]
     */
    private $providers = array(
        'Flasher\Laravel\ServiceProvider\Providers\Laravel4',
        'Flasher\Laravel\ServiceProvider\Providers\Laravel50',
        'Flasher\Laravel\ServiceProvider\Providers\Laravel51',
        'Flasher\Laravel\ServiceProvider\Providers\Laravel',
        'Flasher\Laravel\ServiceProvider\Providers\Lumen',
    );

    private $notifyServiceProvider;

    public function __construct(FlasherServiceProvider $notifyServiceProvider)
    {
        $this->notifyServiceProvider = $notifyServiceProvider;
    }

    public function boot()
    {
        $provider = $this->resolveServiceProvider();

        $provider->publishes($this->notifyServiceProvider);
        $provider->registerBladeDirectives();
    }

    public function register()
    {
        $provider = $this->resolveServiceProvider();
        $provider->registerServices();
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
