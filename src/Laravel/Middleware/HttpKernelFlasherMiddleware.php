<?php

namespace Flasher\Laravel\Middleware;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Request as SymfonyRequest;
use Symfony\Component\HttpKernel\HttpKernelInterface;

final class HttpKernelFlasherMiddleware implements HttpKernelInterface
{
    /**
     * @var \Symfony\Component\HttpKernel\HttpKernelInterface
     */
    private $app;

    public function __construct(HttpKernelInterface $app)
    {
        $this->app = $app;
    }

    public function handle(SymfonyRequest $request, $type = HttpKernelInterface::MASTER_REQUEST, $catch = true)
    {
        $response = $this->app->handle($request, $type, $catch);

        $request = Request::createFromBase($request);
        $next = function () use ($response) {
            return $response;
        };

        /** @var SessionMiddleware $sessionMiddleware */
        $sessionMiddleware = $this->app->make('Flasher\Laravel\Middleware\FlasherMiddleware');

        return $sessionMiddleware->handle($request, $next);
    }
}
