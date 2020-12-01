<?php

namespace Flasher\Prime\TestsMiddleware;

use Notify\Envelope;
use Flasher\Prime\TestsStamp\RenderedAtStamp;

final class AddRenderedAtStampMiddleware implements MiddlewareInterface
{
    public function handle(Envelope $envelope, callable $next)
    {
        if (null === $envelope->get('Flasher\Prime\TestsStamp\RenderedAtStamp')) {
            $envelope->withStamp(new RenderedAtStamp());
        }

        return $next($envelope);
    }
}
