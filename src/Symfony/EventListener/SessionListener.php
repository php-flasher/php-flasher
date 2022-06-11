<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

namespace Flasher\Symfony\EventListener;

use Flasher\Prime\Http\RequestExtension;
use Flasher\Symfony\Http\Request;
use Flasher\Symfony\Http\Response;
use Symfony\Component\HttpKernel\Event\ResponseEvent;

final class SessionListener
{
    /**
     * @var RequestExtension
     */
    private $requestExtension;

    public function __construct(RequestExtension $requestExtension)
    {
        $this->requestExtension = $requestExtension;
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

        $this->requestExtension->flash($request, $response);
    }
}
