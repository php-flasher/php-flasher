<?php

declare(strict_types=1);

namespace Flasher\Noty\Laravel;

use Flasher\Prime\EventDispatcher\Event\ResponseEvent;
use Flasher\Prime\EventDispatcher\EventListener\EventListenerInterface;

final readonly class LivewireListener implements EventListenerInterface
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

        if (strripos($response, '<script type="text/javascript" class="flasher-noty-livewire-js"')) {
            return;
        }

        // Inject the Noty-Livewire bridge JavaScript
        $response .= <<<'JAVASCRIPT'
<script type="text/javascript" class="flasher-noty-livewire-js">
    (function() {
        const events = ['flasher:noty:show', 'flasher:noty:click', 'flasher:noty:close', 'flasher:noty:hover'];

        events.forEach(function(eventName) {
            window.addEventListener(eventName, function(event) {
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

                const livewireEventName = eventName.replace('flasher:', '').replace(':', ':');
                Livewire.dispatchTo(component.name, livewireEventName, { payload: detail });
            }, false);
        });
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
