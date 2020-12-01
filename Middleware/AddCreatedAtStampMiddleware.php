<?php

namespace Flasher\Prime\TestsMiddleware;

use Notify\Envelope;
use Flasher\Prime\TestsStamp\CreatedAtStamp;

final class AddCreatedAtStampMiddleware implements MiddlewareInterface
{
    public function handle(Envelope $envelope, callable $next)
    {
        if (null === $envelope->get('Flasher\Prime\TestsStamp\CreatedAtStamp')) {
            $envelope->withStamp(new CreatedAtStamp());
        }

        return $next($envelope);
    }
}
