<?php

namespace Flasher\Prime\Middleware;

use Flasher\Prime\Envelope;

interface MiddlewareInterface
{
    /**
     * @param Envelope $envelope
     * @param callable         $next
     *
     * @return Envelope
     */
    public function handle(Envelope $envelope, callable $next);
}
