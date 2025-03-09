<?php

declare(strict_types=1);

namespace Flasher\Symfony\EventListener;

use Flasher\Prime\Http\ResponseExtensionInterface;
use Flasher\Symfony\Http\Request;
use Flasher\Symfony\Http\Response;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ResponseEvent;

/**
 * FlasherListener - Injects PHPFlasher assets into responses.
 *
 * This event subscriber listens for kernel.response events and injects
 * PHPFlasher JavaScript and CSS assets into appropriate HTTP responses.
 * It adapts Symfony's request and response objects to PHPFlasher's interfaces.
 *
 * Design patterns:
 * - Observer Pattern: Observes Symfony's kernel events
 * - Adapter Pattern: Adapts Symfony's request/response to PHPFlasher's interfaces
 * - Event Subscriber: Subscribes to Symfony's event dispatcher system
 */
final readonly class FlasherListener implements EventSubscriberInterface
{
    /**
     * Creates a new FlasherListener instance.
     *
     * @param ResponseExtensionInterface $responseExtension Service for extending responses with notifications
     */
    public function __construct(private ResponseExtensionInterface $responseExtension)
    {
    }

    /**
     * Processes the response to inject PHPFlasher assets.
     *
     * This handler adapts Symfony's request and response objects to PHPFlasher's
     * interfaces, then delegates to the response extension for asset injection.
     *
     * @param ResponseEvent $event The response event
     */
    public function onKernelResponse(ResponseEvent $event): void
    {
        $request = new Request($event->getRequest());
        $response = new Response($event->getResponse());

        $this->responseExtension->render($request, $response);
    }

    /**
     * {@inheritdoc}
     *
     * Returns events this subscriber listens to and their corresponding handlers.
     * The low priority (-20) ensures this runs after most other response listeners.
     *
     * @return array<string, array<int, int|string>> The events and handlers
     */
    public static function getSubscribedEvents(): array
    {
        return [
            ResponseEvent::class => ['onKernelResponse', -20],
        ];
    }
}
