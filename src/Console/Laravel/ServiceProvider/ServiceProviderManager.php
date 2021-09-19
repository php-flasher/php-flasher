<?php

namespace Flasher\Console\Laravel\ServiceProvider;

use Flasher\Console\Laravel\FlasherConsoleServiceProvider;
use Flasher\Console\Laravel\ServiceProvider\Providers\ServiceProviderInterface;

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
        'Flasher\Console\Laravel\ServiceProvider\Providers\Laravel4',
        'Flasher\Console\Laravel\ServiceProvider\Providers\Laravel',
    );

    /**
     * @var FlasherConsoleServiceProvider
     */
    private $notifyServiceProvider;

    public function __construct(FlasherConsoleServiceProvider $notifyServiceProvider)
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
