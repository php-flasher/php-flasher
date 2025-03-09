<?php

declare(strict_types=1);

namespace Flasher\Symfony\EventListener;

use Flasher\Prime\Http\RequestExtensionInterface;
use Flasher\Symfony\Http\Request;
use Flasher\Symfony\Http\Response;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ResponseEvent;

/**
 * SessionListener - Processes session flash messages.
 *
 * This event subscriber listens for kernel.response events and converts
 * Symfony's session flash messages to PHPFlasher notifications. This enables
 * PHPFlasher to work with existing code that uses Symfony's flash messaging.
 *
 * Design patterns:
 * - Observer Pattern: Observes Symfony's kernel events
 * - Adapter Pattern: Adapts Symfony's flash messages to PHPFlasher notifications
 * - Transformer Pattern: Transforms data from one format to another
 */
final readonly class SessionListener implements EventSubscriberInterface
{
    /**
     * Creates a new SessionListener instance.
     *
     * @param RequestExtensionInterface $requestExtension Service for processing request flash messages
     */
    public function __construct(private RequestExtensionInterface $requestExtension)
    {
    }

    /**
     * Processes the request to convert flash messages to notifications.
     *
     * This handler adapts Symfony's request and response objects to PHPFlasher's
     * interfaces, then delegates to the request extension for flash processing.
     *
     * @param ResponseEvent $event The response event
     */
    public function onKernelResponse(ResponseEvent $event): void
    {
        $request = new Request($event->getRequest());
        $response = new Response($event->getResponse());

        $this->requestExtension->flash($request, $response);
    }

    /**
     * {@inheritdoc}
     *
     * Returns events this subscriber listens to and their corresponding handlers.
     *
     * @return array<string, array<int, int|string>> The events and handlers
     */
    public static function getSubscribedEvents(): array
    {
        return [
            ResponseEvent::class => ['onKernelResponse', 0],
        ];
    }
}
