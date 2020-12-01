<?php

namespace Flasher\Prime\TestsMiddleware;

use Notify\Envelope;
use Flasher\Prime\TestsStamp\ReplayStamp;

final class AddReplayStampMiddleware implements MiddlewareInterface
{
    public function handle(Envelope $envelope, callable $next)
    {
        if (null === $envelope->get('Flasher\Prime\TestsStamp\ReplayStamp')) {
            $envelope->withStamp(new ReplayStamp(1));
        }

        return $next($envelope);
    }
}
