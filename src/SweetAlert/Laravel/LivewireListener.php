<?php

declare(strict_types=1);

namespace Flasher\SweetAlert\Laravel;

use Flasher\Prime\EventDispatcher\Event\ResponseEvent;
use Flasher\Prime\EventDispatcher\EventListener\EventListenerInterface;

final class LivewireListener implements EventListenerInterface
{
    public function __invoke(ResponseEvent $event): void
    {
        if ('html' !== $event->getPresenter()) {
            return;
        }

        $response = $event->getResponse() ?: '';
        if (!\is_string($response)) {
            return;
        }

        if (false === strripos($response, '<script type="text/javascript" class="flasher-js">')) {
            return;
        }

        $response .= <<<'JAVASCRIPT'
<script type="text/javascript">
    window.addEventListener('flasher:sweetalert:promise', function (event) {
        var envelope = event.detail.envelope;
        var context = envelope.context;

        if (!context.livewire || !context.livewire.id) {
            return;
        }

        var params = event.detail;
        var componentId = context.livewire.id;

        Livewire.components.emitSelf(componentId, 'sweetalertEvent', params);

        var promise = event.detail.promise;
        if (promise.isConfirmed) {
            Livewire.components.emitSelf(componentId, 'sweetalertConfirmed', params);
        }

        if (promise.isDenied) {
            Livewire.components.emitSelf(componentId, 'sweetalertDenied', params);
        }

        if (promise.isDismissed) {
            Livewire.components.emitSelf(componentId, 'sweetalertDismissed', params);
        }
    }, false);
</script>
JAVASCRIPT;

        $event->setResponse($response);
    }

    public function getSubscribedEvents(): string|array
    {
        return ResponseEvent::class;
    }
}
