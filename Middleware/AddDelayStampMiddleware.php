<?php

namespace Flasher\Prime\Middleware;

use Flasher\Prime\Envelope;
use Flasher\Prime\Stamp\DelayStamp;

final class AddDelayStampMiddleware implements MiddlewareInterface
{
    public function handle(Envelope $envelope, callable $next)
    {
        if (null === $envelope->get('Flasher\Prime\Stamp\DelayStamp')) {
            $envelope->withStamp(new DelayStamp(0));
        }

        return $next($envelope);
    }
}
