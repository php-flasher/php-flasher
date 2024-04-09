<?php

declare(strict_types=1);

namespace Flasher\SweetAlert\Laravel;

use Flasher\Prime\EventDispatcher\Event\ResponseEvent;
use Flasher\Prime\EventDispatcher\EventListener\EventListenerInterface;

final readonly class LivewireListener implements EventListenerInterface
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

        if (false === strripos($response, '<script type="text/javascript" class="flasher-js"')) {
            return;
        }

        if (strripos($response, '<script type="text/javascript" class="flasher-sweetalert-promise-js"')) {
            return;
        }

        $response .= <<<'JAVASCRIPT'
<script type="text/javascript" class="flasher-sweetalert-promise-js">
    window.addEventListener('flasher:sweetalert:promise', function (event) {
        if (typeof Livewire === 'undefined') {
            console.error('Livewire is not defined.');
            return;
        }

        const { detail } = event;
        const { envelope, promise } = detail;
        const { context } = envelope;

        if (!context.livewire?.id) {
            return;
        }

        const { livewire: { id: componentId } } = context;
        const component = Livewire.all().find(c => c.id === componentId);

        if (!component) {
            console.error('Livewire component not found');
            return;
        }

        const dispatchToLivewire = (eventName) => {
            Livewire.dispatchTo(component.name, eventName, { payload: detail });
        }

        dispatchToLivewire('sweetalert:event');
        promise.isConfirmed && dispatchToLivewire('sweetalert:confirmed');
        promise.isDenied && dispatchToLivewire('sweetalert:denied');
        promise.isDismissed && dispatchToLivewire('sweetalert:dismissed');
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
