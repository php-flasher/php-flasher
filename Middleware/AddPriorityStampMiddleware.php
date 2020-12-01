<?php

namespace Flasher\Prime\TestsMiddleware;

use Notify\Envelope;
use Flasher\Prime\TestsStamp\PriorityStamp;

final class AddPriorityStampMiddleware implements MiddlewareInterface
{
    public function handle(Envelope $envelope, callable $next)
    {
        if (null === $envelope->get('Flasher\Prime\TestsStamp\PriorityStamp')) {
            $envelope->withStamp(new PriorityStamp(0));
        }

        return $next($envelope);
    }
}
