<?php

namespace Flasher\Prime\Middleware;

use Flasher\Prime\Envelope;
use Flasher\Prime\Notification\NotificationInterface;

interface FlasherBusInterface
{
    /**
     * Executes the given command and optionally returns a value
     *
     * @param Envelope|NotificationInterface $envelope
     * @param array                          $stamps
     *
     * @return mixed
     */
    public function dispatch($envelope, $stamps = array());

    /**
     * @param MiddlewareInterface $middleware
     *
     * @return $this
     */
    public function addMiddleware(MiddlewareInterface $middleware);
}
