<?php

namespace Flasher\Prime\Middleware;

use Flasher\Prime\Envelope;
use Flasher\Prime\Stamp\PriorityStamp;

final class AddPriorityStampMiddleware implements MiddlewareInterface
{
    public function handle(Envelope $envelope, callable $next)
    {
        if (null === $envelope->get('Flasher\Prime\Stamp\PriorityStamp')) {
            $envelope->withStamp(new PriorityStamp(0));
        }

        return $next($envelope);
    }
}
