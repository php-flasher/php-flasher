<?php

namespace Flasher\Prime\TestsMiddleware;

use Notify\Envelope;

interface MiddlewareInterface
{
    /**
     * @param \Notify\Envelope $envelope
     * @param callable         $next
     *
     * @return \Notify\Envelope
     */
    public function handle(Envelope $envelope, callable $next);
}
