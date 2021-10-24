<?php

namespace Flasher\Laravel\ServiceProvider;

use Flasher\Laravel\FlasherServiceProvider;
use Flasher\Laravel\ServiceProvider\Providers\Laravel;
use Flasher\Laravel\ServiceProvider\Providers\Laravel4;
use Flasher\Laravel\ServiceProvider\Providers\Laravel50;
use Flasher\Laravel\ServiceProvider\Providers\Laravel51;
use Flasher\Laravel\ServiceProvider\Providers\ServiceProviderInterface;
use Illuminate\Container\Container;

final class ServiceProviderManager
{
    /** @var ServiceProviderInterface|null */
    private $provider;

    /**
     * @var ServiceProviderInterface[]
     */
    private $providers;

    /** @var FlasherServiceProvider  */
    private $notifyServiceProvider;

    public function __construct(FlasherServiceProvider $notifyServiceProvider, Container $app)
    {
        $this->notifyServiceProvider = $notifyServiceProvider;

        $this->providers = array(
            new Laravel4($app),
            new Laravel50($app),
            new Laravel51($app),
            new Laravel($app),
        );
    }

    /**
     * @return void
     */
    public function boot()
    {
        $provider = $this->resolveServiceProvider();
        $provider->boot($this->notifyServiceProvider);
    }

    /**
     * @return void
     */
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

        foreach ($this->providers as $provider) {
            if ($provider->shouldBeUsed()) {
                return $this->provider = $provider;
            }
        }

        throw new \InvalidArgumentException('Service Provider not found.');
    }
}
