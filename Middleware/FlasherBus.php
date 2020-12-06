<?php

namespace Flasher\Prime\Middleware;

use Flasher\Prime\Envelope;

final class FlasherBus implements FlasherBusInterface
{
    /**
     * @var MiddlewareInterface[]
     */
    private $middlewares = array();

    /**
     * @inheritDoc
     */
    public function dispatch($envelope, $stamps = array())
    {
        $envelope = Envelope::wrap($envelope, $stamps);

        $middlewareChain = $this->createExecutionChain();

        $middlewareChain($envelope);

        return $envelope;
    }

    /**
     * @inheritDoc
     */
    public function addMiddleware(MiddlewareInterface $middleware)
    {
        $this->middlewares[] = $middleware;

        return $this;
    }

    /**
     * @return callable
     */
    private function createExecutionChain()
    {
        $lastCallable = static function () {
            // the final callable is a no-op
        };

        $middlewares = $this->middlewares;

        while ($middleware = array_pop($middlewares)) {
            $lastCallable = static function ($command) use ($middleware, $lastCallable) {
                return $middleware->handle($command, $lastCallable);
            };
        }

        return $lastCallable;
    }
}
