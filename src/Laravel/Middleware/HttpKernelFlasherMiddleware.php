<?php

declare(strict_types=1);

namespace Flasher\Laravel\Middleware;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Request as SymfonyRequest;
use Symfony\Component\HttpKernel\HttpKernelInterface;

final class HttpKernelFlasherMiddleware implements HttpKernelInterface
{
    public function __construct(private readonly HttpKernelInterface $app)
    {
    }

    public function handle(SymfonyRequest $request, $type = HttpKernelInterface::MASTER_REQUEST, $catch = true): \Symfony\Component\HttpFoundation\Response
    {
        $response = $this->app->handle($request, $type, $catch);

        $request = Request::createFromBase($request);
        $next = static fn (): \Symfony\Component\HttpFoundation\Response => $response;

        /** @var SessionMiddleware $sessionMiddleware */
        $sessionMiddleware = $this->app->make(\Flasher\Laravel\Middleware\FlasherMiddleware::class);

        return $sessionMiddleware->handle($request, $next);
    }
}
