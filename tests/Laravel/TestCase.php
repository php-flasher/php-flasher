<?php

declare(strict_types=1);

namespace Flasher\Tests\Laravel;

use Flasher\Laravel\Support\Laravel;
use Illuminate\Config\Repository as Config;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Facade;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    public function createApplication()
    {
        if (!str_starts_with(Application::VERSION, '4.0')) {
            return parent::createApplication();
        }

        $app = new Application();

        $app->detectEnvironment([
            'local' => ['your-machine-name'],
        ]);

        $app->bindInstallPaths($this->getApplicationPaths());

        $app['env'] = 'testing';

        $app->instance('app', $app);

        Facade::clearResolvedInstances();
        Facade::setFacadeApplication($app);

        $config = new Config($app->getConfigLoader(), $app['env']);
        $app->instance('config', $config);
        $app->startExceptionHandling();

        if ($app->runningInConsole()) {
            $app->setRequestForConsoleEnvironment();
        }

        date_default_timezone_set($this->getApplicationTimezone());

        $aliases = [...$this->getApplicationAliases(), ...$this->getPackageAliases()];
        AliasLoader::getInstance($aliases)->register();

        Request::enableHttpMethodParameterOverride();

        $providers = array_merge($this->getApplicationProviders(), $this->getPackageProviders());
        $app->getProviderRepository()->load($app, $providers);

        $this->getEnvironmentSetUp($app);

        $app->boot();

        return $app;
    }

    /**
     * @param Application|null $app
     *
     * @return string[]
     */
    protected function getPackageProviders($app = null)
    {
        return [
            \Flasher\Laravel\FlasherPluginServiceProvider::class,
            \Flasher\Noty\Laravel\FlasherNotyPluginServiceProvider::class,
            \Flasher\Notyf\Laravel\FlasherNotyfPluginServiceProvider::class,
            \Flasher\Pnotify\Laravel\FlasherPnotifyPluginServiceProvider::class,
            \Flasher\SweetAlert\Laravel\FlasherSweetAlertPluginServiceProvider::class,
            \Flasher\Toastr\Laravel\FlasherToastrServiceProvider::class,
        ];
    }

    /**
     * @param Application $app
     */
    protected function getEnvironmentSetUp($app)
    {
        $separator = Laravel::isVersion('4') ? '::config' : '';

        $app->make('config')->set('session.driver', 'array');
        $app->make('config')->set('session'.$separator.'.driver', 'array');
    }
}
