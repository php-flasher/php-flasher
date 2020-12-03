<?php

namespace Flasher\Prime\Middleware;

use Flasher\Prime\Envelope;
use Flasher\Prime\Stamp\CreatedAtStamp;

final class AddCreatedAtStampMiddleware implements MiddlewareInterface
{
    public function handle(Envelope $envelope, callable $next)
    {
        if (null === $envelope->get('Flasher\Prime\Stamp\CreatedAtStamp')) {
            $envelope->withStamp(new CreatedAtStamp());
        }

        return $next($envelope);
    }
}
