<?php

namespace Flasher\Prime\Middleware;

use Flasher\Prime\Envelope;
use Flasher\Prime\Stamp\RenderedAtStamp;

final class AddRenderedAtStampMiddleware implements MiddlewareInterface
{
    public function handle(Envelope $envelope, callable $next)
    {
        if (null === $envelope->get('Flasher\Prime\Stamp\RenderedAtStamp')) {
            $envelope->withStamp(new RenderedAtStamp());
        }

        return $next($envelope);
    }
}
