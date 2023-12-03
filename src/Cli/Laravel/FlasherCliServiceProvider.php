<?php

declare(strict_types=1);

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
    public function boot(): void
    {
        $this->processConfiguration();
        $this->registerRenderListener();
        $this->registerPresenter();
    }

    public function register(): void
    {
        $this->registerNotifierFactory();
        $this->registerNotifier();
    }

    private function processConfiguration(): void
    {
        $name = 'flasher_cli';
        $config = $this->app->make('config');

        $config->set($name, $config->get($name, [])); // @phpstan-ignore-line
    }

    private function registerNotifierFactory(): void
    {
        $this->app->singleton('flasher.cli', static function (Container $app): CliFactory {
            return new CliFactory($app->make('flasher.storage_manager'));
            // @phpstan-ignore-line
        });

        $this->app->alias('flasher.cli', \Flasher\Cli\Prime\CliFactory::class);
    }

    private function registerNotifier(): void
    {
        $this->app->singleton('flasher.notify', static function (Container $app): Notify {
            /** @phpstan-ignore-next-line */
            $title = $app->make('config')->get('flasher_cli.title', null);
            $icons = $app->make('config')->get('flasher_cli.icons', []);

            // @phpstan-ignore-line
            return new Notify($title, $icons);
        });

        $this->app->alias('flasher.notify', \Flasher\Cli\Prime\Notify::class);
        $this->app->alias('flasher.notify', \Flasher\Cli\Prime\NotifyInterface::class);
    }

    private function registerRenderListener(): void
    {
        /** @var FlasherInterface $flasher */
        $flasher = $this->app->make('flasher');
        $this->app->extend('flasher.event_dispatcher', static function (EventDispatcherInterface $dispatcher) use ($flasher): \Flasher\Prime\EventDispatcher\EventDispatcherInterface {
            $dispatcher->addSubscriber(new RenderListener($flasher));

            return $dispatcher;
        });
    }

    private function registerPresenter(): void
    {
        $this->app->extend('flasher.response_manager', static function (ResponseManagerInterface $manager, Container $app): ResponseManagerInterface {
            $manager->addPresenter(CliPresenter::NAME, new CliPresenter($app->make('flasher.notify')));

            // @phpstan-ignore-line
            return $manager;
        });
    }
}
