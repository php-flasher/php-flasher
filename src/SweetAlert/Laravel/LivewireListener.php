<?php

declare(strict_types=1);

namespace Flasher\SweetAlert\Laravel;

use Flasher\Prime\EventDispatcher\Event\ResponseEvent;
use Flasher\Prime\EventDispatcher\EventListener\EventListenerInterface;

/**
 * LivewireListener - Enables SweetAlert interactivity with Livewire components.
 *
 * This event listener injects JavaScript code that bridges SweetAlert's promise-based
 * API with Livewire's event system. It enables Livewire components to respond to
 * user interactions with SweetAlert dialogs (confirm, deny, dismiss actions).
 *
 * Design patterns:
 * - Observer: Observes PHPFlasher response events
 * - Bridge: Connects SweetAlert's JavaScript API to Livewire's event system
 * - Event-driven: Uses event-driven architecture for loose coupling
 */
final readonly class LivewireListener implements EventListenerInterface
{
    /**
     * Handles the response event by injecting SweetAlert-Livewire bridge code.
     *
     * When an HTML response is being prepared, this method adds JavaScript that will:
     * 1. Listen for SweetAlert promise events
     * 2. Forward these events to the appropriate Livewire component
     * 3. Include payload data for the component to process
     *
     * @param ResponseEvent $event The response event being processed
     */
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

        if (strripos($response, '<script type="text/javascript" class="flasher-sweetalert-promise-js"')) {
            return;
        }

        // Inject the SweetAlert-Livewire bridge JavaScript
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

    /**
     * Specifies which events this listener should subscribe to.
     *
     * @return string The event class name this listener handles
     */
    public function getSubscribedEvents(): string
    {
        return ResponseEvent::class;
    }
}
