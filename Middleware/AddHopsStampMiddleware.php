<?php

namespace Flasher\Prime\Middleware;

use Flasher\Prime\Envelope;
use Flasher\Prime\Stamp\HopsStamp;

final class AddHopsStampMiddleware implements MiddlewareInterface
{
    public function handle(Envelope $envelope, callable $next)
    {
        if (null === $envelope->get('Flasher\Prime\Stamp\HopsStamp')) {
            $envelope->withStamp(new HopsStamp(1));
        }

        return $next($envelope);
    }
}
