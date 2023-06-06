<?php

namespace Flasher\Cli\Laravel;

use Flasher\Cli\Prime\CliFactory;
use Flasher\Cli\Prime\EventListener\RenderListener;
use Flasher\Cli\Prime\Notify;
use Flasher\Cli\Prime\Presenter\CliPresenter;
use Flasher\Prime\EventDispatcher\EventDispatcherInterface;
use Flasher\Prime\FlasherInterface;
use Flasher\Prime\Response\ResponseManagerInterface;
use Illuminate\Container\Container;
use Illuminate\Support\ServiceProvider;

final class FlasherCliServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function boot()
    {
        $this->processConfiguration();
        $this->registerRenderListener();
        $this->registerPresenter();
    }

    public function register()
    {
        $this->registerNotifierFactory();
        $this->registerNotifier();
    }

    /**
     * @return void
     */
    private function processConfiguration()
    {
        $name = 'flasher_cli';
        $config = $this->app->make('config');

        $config->set($name, $config->get($name, [])); // @phpstan-ignore-line
    }

    /**
     * @return void
     */
    private function registerNotifierFactory()
    {
        $this->app->singleton('flasher.cli', function (Container $app) {
            return new CliFactory($app->make('flasher.storage_manager')); // @phpstan-ignore-line
        });

        $this->app->alias('flasher.cli', 'Flasher\Cli\Prime\CliFactory');
    }

    /**
     * @return void
     */
    private function registerNotifier()
    {
        $this->app->singleton('flasher.notify', function (Container $app) {
            /** @phpstan-ignore-next-line */
            $title = $app->make('config')->get('flasher_cli.title', null);
            $icons = $app->make('config')->get('flasher_cli.icons', []); // @phpstan-ignore-line

            return new Notify($title, $icons);
        });

        $this->app->alias('flasher.notify', 'Flasher\Cli\Prime\Notify');
        $this->app->alias('flasher.notify', 'Flasher\Cli\Prime\NotifyInterface');
    }

    /**
     * @return void
     */
    private function registerRenderListener()
    {
        /** @var FlasherInterface $flasher */
        $flasher = $this->app->make('flasher');
        $this->app->extend('flasher.event_dispatcher', function (EventDispatcherInterface $dispatcher) use ($flasher) {
            $dispatcher->addSubscriber(new RenderListener($flasher));

            return $dispatcher;
        });
    }

    /**
     * @return void
     */
    private function registerPresenter()
    {
        $this->app->extend('flasher.response_manager', function (ResponseManagerInterface $manager, Container $app) {
            $manager->addPresenter(CliPresenter::NAME, new CliPresenter($app->make('flasher.notify'))); // @phpstan-ignore-line

            return $manager;
        });
    }
}
