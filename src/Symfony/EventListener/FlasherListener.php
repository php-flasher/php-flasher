<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

namespace Flasher\Symfony\EventListener;

use Flasher\Prime\Http\ResponseExtension;
use Flasher\Symfony\Http\Request;
use Flasher\Symfony\Http\Response;
use Symfony\Component\HttpKernel\Event\ResponseEvent;

final class FlasherListener
{
    /**
     * @var ResponseExtension
     */
    private $responseExtension;

    public function __construct(ResponseExtension $responseExtension)
    {
        $this->responseExtension = $responseExtension;
    }

    /**
     * @param ResponseEvent $event
     *
     * @return void
     */
    public function onKernelResponse($event)
    {
        $request = new Request($event->getRequest());
        $response = new Response($event->getResponse());

        $this->responseExtension->render($request, $response);
    }
}
