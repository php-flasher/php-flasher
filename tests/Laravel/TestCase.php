<?php

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

        $aliases = array_merge($this->getApplicationAliases(), $this->getPackageAliases());
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
            'Flasher\Laravel\FlasherServiceProvider',
            'Flasher\Noty\Laravel\FlasherNotyServiceProvider',
            'Flasher\Notyf\Laravel\FlasherNotyfServiceProvider',
            'Flasher\Pnotify\Laravel\FlasherPnotifyServiceProvider',
            'Flasher\SweetAlert\Laravel\FlasherSweetAlertServiceProvider',
            'Flasher\Toastr\Laravel\FlasherToastrServiceProvider',
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
