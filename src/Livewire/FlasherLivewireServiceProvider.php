<?php

declare(strict_types=1);

namespace Flasher\Livewire;

use Flasher\Prime\Notification\NotificationBuilder;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

final class FlasherLivewireServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application events.
     */
    public function boot()
    {
        NotificationBuilder::macro('livewire', function (array $context = []) {
            return $this->withStamp(new LivewireStamp($context));
        });

        Livewire::listen('component.dehydrate', function ($component, $response) {
            $data = $this->app['flasher.response_manager']->render(array(
                'stamps' => LivewireStamp::class,
            ), 'array');

            if (count($data['envelopes']) > 0) {
                $data['context']['livewire'] = $response->fingerprint;
                $response->effects['dispatches'][] = [
                    'event' => 'flasher:render',
                    'data' => $data,
                ];
            }
        });

        Blade::directive('flasher_livewire_render', function () {
            return "<?php echo app('flasher.livewire_response_manager')->render(); ?>";
        });
    }

    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->app->singleton('flasher.livewire_response_manager', function (Application $app) {
            return new LivewireResponseManager($app['flasher.config']);
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return string[]
     */
    public function provides()
    {
        return array(
            'flasher.livewire_response_manager',
        );
    }
}
