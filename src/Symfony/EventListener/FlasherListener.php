<?php

declare(strict_types=1);

namespace Flasher\Symfony\EventListener;

use Flasher\Prime\Http\ResponseExtension;
use Flasher\Symfony\Http\Request;
use Flasher\Symfony\Http\Response;
use Symfony\Component\HttpKernel\Event\ResponseEvent;

final class FlasherListener
{
    public function __construct(private readonly ResponseExtension $responseExtension)
    {
    }

    /**
     * @param  ResponseEvent  $event
     */
    public function onKernelResponse($event): void
    {
        $request = new Request($event->getRequest());
        $response = new Response($event->getResponse());

        $this->responseExtension->render($request, $response);
    }
}
