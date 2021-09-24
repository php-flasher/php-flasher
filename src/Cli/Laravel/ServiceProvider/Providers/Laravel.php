<?php

namespace Flasher\Cli\Laravel\ServiceProvider\Providers;

use Flasher\Cli\Prime\EventListener\RenderListener;
use Flasher\Cli\Prime\FlasherCli;
use Flasher\Cli\Prime\Notifier\NotifySendNotifier;
use Flasher\Cli\Laravel\FlasherCliServiceProvider;
use Flasher\Prime\EventDispatcher\EventDispatcher;
use Illuminate\Container\Container;
use Illuminate\Foundation\Application;

class Laravel implements ServiceProviderInterface
{
    /**
     * @var Container
     */
    protected $app;

    public function __construct(Container $app)
    {
        $this->app = $app;
    }

    public function shouldBeUsed()
    {
        return $this->app instanceof Application;
    }

    public function boot(FlasherCliServiceProvider $provider)
    {
        $provider->publishes(array(
            flasher_path(__DIR__ . '/../../Resources/config/config.php') => config_path('flasher_console.php'),
        ), 'flasher-config');
    }

    public function register(FlasherCliServiceProvider $provider)
    {
        $provider->mergeConfigFrom(flasher_path(__DIR__ . '/../../Resources/config/config.php'), 'flasher_console');

        $this->registerServices();
    }

    public function registerServices()
    {
        $this->app->singleton('flasher.console.notify_send', function (Container $app) {
            $options = $app['config']->get('flasher_console.notify_send', array());

            $options['icons'] = array_replace_recursive($app['config']->get('flasher_console.icons', array()), $options['icons']);
            $options['title'] = $app['config']->get('flasher_console.title', null);
            $options['mute'] = $app['config']->get('flasher_console.mute', true);

            return new NotifySendNotifier($options);
        });



        $this->app->singleton('flasher.console', function (Container $app) {
            $console = new FlasherCli();

            $console->addNotifier($app['flasher.console.notify_send']);

            return $console;
        });

        $this->app->extend('flasher.event_dispatcher', function (EventDispatcher $eventDispatcher, Container $app) {
            $eventDispatcher->addSubscriber(new RenderListener($app['flasher.console']));

            return $eventDispatcher;
        });

        $this->app->alias('flasher.console', 'Flasher\Console\Prime\FlasherCli');
    }
}
