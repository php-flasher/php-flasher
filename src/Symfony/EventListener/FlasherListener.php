<?php

declare(strict_types=1);

namespace Flasher\Symfony\EventListener;

use Flasher\Prime\Http\ResponseExtensionInterface;
use Flasher\Symfony\Http\Request;
use Flasher\Symfony\Http\Response;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ResponseEvent;

final readonly class FlasherListener implements EventSubscriberInterface
{
    public function __construct(private ResponseExtensionInterface $responseExtension)
    {
    }

    public function onKernelResponse(ResponseEvent $event): void
    {
        $request = new Request($event->getRequest());
        $response = new Response($event->getResponse());

        $this->responseExtension->render($request, $response);
    }

    public static function getSubscribedEvents(): array
    {
        return [
            ResponseEvent::class => ['onKernelResponse', -20],
        ];
    }
}
