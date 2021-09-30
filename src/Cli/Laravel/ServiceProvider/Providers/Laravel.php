<?php

namespace Flasher\Cli\Laravel\ServiceProvider\Providers;

use Flasher\Cli\Laravel\FlasherCliServiceProvider;
use Flasher\Cli\Prime\CliNotificationFactory;
use Flasher\Cli\Prime\EventListener\RenderListener;
use Flasher\Cli\Prime\EventListener\StampsListener;
use Flasher\Cli\Prime\Notifier\GrowlNotifyNotifier;
use Flasher\Cli\Prime\Notifier\KDialogNotifier;
use Flasher\Cli\Prime\Notifier\NotifuNotifier;
use Flasher\Cli\Prime\Notifier\NotifySendNotifier;
use Flasher\Cli\Prime\Notifier\SnoreToastNotifier;
use Flasher\Cli\Prime\Notifier\TerminalNotifierNotifier;
use Flasher\Cli\Prime\Notifier\ToasterNotifier;
use Flasher\Cli\Prime\Presenter\CliPresenter;
use Flasher\Prime\EventDispatcher\EventDispatcher;
use Flasher\Prime\Response\ResponseManager;
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
            flasher_path(__DIR__.'/../../Resources/config/config.php') => config_path('flasher_cli.php'),
        ), 'flasher-config');

        $this->app['flasher.response_manager']->addPresenter('cli', $this->app['flasher.presenter.cli']);
        $this->app['flasher.event_dispatcher']->addSubscriber(new RenderListener($this->app['flasher.cli']));
        $this->app['flasher.event_dispatcher']->addSubscriber(new StampsListener(
            $this->app['config']->get('flasher_cli.render_all', false),
            $this->app['config']->get('flasher_cli.render_immediately', true)
        ));

    }

    public function register(FlasherCliServiceProvider $provider)
    {
        $provider->mergeConfigFrom(flasher_path(__DIR__.'/../../Resources/config/config.php'), 'flasher_cli');

        $this->registerServices();
    }

    public function registerServices()
    {
        $this->app->singleton('flasher.cli', function (Container $app) {
            return new CliNotificationFactory(
                $app['flasher.storage_manager'],
                $app['flasher.response_manager'],
                $app['config']->get('flasher_cli.filter_criteria', array())
            );
        });

        $this->app->singleton('flasher.cli.growl_notify', function (Container $app) {
            return new GrowlNotifyNotifier(Laravel::createConfigFor($app, 'growl_notify'));
        });

        $this->app->singleton('flasher.cli.kdialog_notifier', function (Container $app) {
            return new KDialogNotifier(Laravel::createConfigFor($app, 'kdialog_notifier'));
        });

        $this->app->singleton('flasher.cli.notifu_notifier', function (Container $app) {
            return new NotifuNotifier(Laravel::createConfigFor($app, 'notifu_notifier'));
        });

        $this->app->singleton('flasher.cli.notify_send', function (Container $app) {
            return new NotifySendNotifier(Laravel::createConfigFor($app, 'notify_send'));
        });

        $this->app->singleton('flasher.cli.snore_toast_notifier', function (Container $app) {
            return new SnoreToastNotifier(Laravel::createConfigFor($app, 'snore_toast_notifier'));
        });

        $this->app->singleton('flasher.cli.terminal_notifier_notifier', function (Container $app) {
            return new TerminalNotifierNotifier(Laravel::createConfigFor($app, 'terminal_notifier_notifier'));
        });

        $this->app->singleton('flasher.cli.toaster', function (Container $app) {
            return new ToasterNotifier(Laravel::createConfigFor($app, 'toaster'));
        });

        $this->app->singleton('flasher.presenter.cli', function (Container $app) {
            $presenter = new CliPresenter();

            $presenter->addNotifier($app['flasher.cli.growl_notify']);
            $presenter->addNotifier($app['flasher.cli.kdialog_notifier']);
            $presenter->addNotifier($app['flasher.cli.notifu_notifier']);
            $presenter->addNotifier($app['flasher.cli.notify_send']);
            $presenter->addNotifier($app['flasher.cli.snore_toast_notifier']);
            $presenter->addNotifier($app['flasher.cli.terminal_notifier_notifier']);
            $presenter->addNotifier($app['flasher.cli.toaster']);

            return $presenter;
        });

        $this->app->alias('flasher.cli', 'Flasher\Cli\Prime\FlasherCli');
        $this->app->alias('Flasher\Cli\Prime\FlasherCli', 'Flasher\Cli\Prime\CliFlasherInterface');
    }

    private static function createConfigFor(Container $app, $notifier)
    {
        $options = $app['config']->get('flasher_cli.notifiers.'.$notifier);

        $options['title'] = $app['config']->get('flasher_cli.title');
        $options['mute'] = $app['config']->get('flasher_cli.mute');
        $options['icons'] = array_replace_recursive($app['config']->get('flasher_cli.icons'), $options['icons']);
        $options['sounds'] = array_replace_recursive($app['config']->get('flasher_cli.sounds'), $options['sounds']);

        return $options;
    }
}
