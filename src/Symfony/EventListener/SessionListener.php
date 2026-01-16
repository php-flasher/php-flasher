<?php

declare(strict_types=1);

namespace Flasher\Symfony\EventListener;

use Flasher\Prime\Http\RequestExtensionInterface;
use Flasher\Symfony\Http\Request;
use Flasher\Symfony\Http\Response;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ResponseEvent;

final readonly class SessionListener implements EventSubscriberInterface
{
    public function __construct(private RequestExtensionInterface $requestExtension)
    {
    }

    public function onKernelResponse(ResponseEvent $event): void
    {
        $request = new Request($event->getRequest());
        $response = new Response($event->getResponse());

        $this->requestExtension->flash($request, $response);
    }

    public static function getSubscribedEvents(): array
    {
        return [
            ResponseEvent::class => ['onKernelResponse', 0],
        ];
    }
}
