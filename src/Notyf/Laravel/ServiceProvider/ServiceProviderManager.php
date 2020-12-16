<?php

namespace Flasher\Notyf\Laravel\ServiceProvider;

use Flasher\Notyf\Laravel\FlasherNotyfServiceProvider;
use Flasher\Notyf\Laravel\ServiceProvider\Providers\ServiceProviderInterface;

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
        'Flasher\Notyf\Laravel\ServiceProvider\Providers\Laravel4',
        'Flasher\Notyf\Laravel\ServiceProvider\Providers\Laravel',
        'Flasher\Notyf\Laravel\ServiceProvider\Providers\Lumen',
    );

    /**
     * @var FlasherNotyfServiceProvider
     */
    private $notifyServiceProvider;

    /**
     * @param FlasherNotyfServiceProvider $notifyServiceProvider
     */
    public function __construct(FlasherNotyfServiceProvider $notifyServiceProvider)
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
