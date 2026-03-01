<?php

declare(strict_types=1);

namespace Flasher\Laravel\EventListener;

use Flasher\Prime\EventDispatcher\Event\ResponseEvent;
use Flasher\Prime\EventDispatcher\EventListener\EventListenerInterface;

final readonly class ThemeLivewireListener implements EventListenerInterface
{
    public function __invoke(ResponseEvent $event): void
    {
        // Only process HTML responses
        if ('html' !== $event->getPresenter()) {
            return;
        }

        $response = $event->getResponse() ?: '';
        if (!\is_string($response)) {
            return;
        }

        // Avoid duplicate script injection
        if (false === strripos($response, '<script type="text/javascript" class="flasher-js"')) {
            return;
        }

        if (strripos($response, '<script type="text/javascript" class="flasher-theme-livewire-js"')) {
            return;
        }

        // Inject the Theme-Livewire bridge JavaScript
        $response .= <<<'JAVASCRIPT'
<script type="text/javascript" class="flasher-theme-livewire-js">
    (function() {
        window.addEventListener('flasher:theme:click', function(event) {
            if (typeof Livewire === 'undefined') {
                return;
            }

            const { detail } = event;
            const { envelope } = detail;
            const context = envelope.context || {};

            if (!context.livewire?.id) {
                return;
            }

            const { livewire: { id: componentId } } = context;
            const component = Livewire.all().find(c => c.id === componentId);

            if (!component) {
                return;
            }

            Livewire.dispatchTo(component.name, 'theme:click', { payload: detail });

            // Also dispatch theme-specific event
            const plugin = envelope.metadata?.plugin || '';
            let themeName = plugin;
            if (plugin.startsWith('theme.')) {
                themeName = plugin.replace('theme.', '');
            }
            if (themeName) {
                Livewire.dispatchTo(component.name, 'theme:' + themeName + ':click', { payload: detail });
            }
        }, false);
    })();
</script>
JAVASCRIPT;

        $event->setResponse($response);
    }

    public function getSubscribedEvents(): string
    {
        return ResponseEvent::class;
    }
}
