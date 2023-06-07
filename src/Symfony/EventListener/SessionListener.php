<?php

declare(strict_types=1);

namespace Flasher\Symfony\EventListener;

use Flasher\Prime\Http\RequestExtension;
use Flasher\Symfony\Http\Request;
use Flasher\Symfony\Http\Response;
use Symfony\Component\HttpKernel\Event\ResponseEvent;

final class SessionListener
{
    public function __construct(private readonly RequestExtension $requestExtension)
    {
    }

    /**
     * @param  ResponseEvent  $event
     */
    public function onKernelResponse($event): void
    {
        $request = new Request($event->getRequest());
        $response = new Response($event->getResponse());

        $this->requestExtension->flash($request, $response);
    }
}
