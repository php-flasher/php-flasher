<?php

declare(strict_types=1);

namespace Flasher\Laravel\Middleware;

use Flasher\Laravel\Http\Request;
use Flasher\Laravel\Http\Response;
use Flasher\Prime\Http\RequestExtensionInterface;
use Illuminate\Http\Request as LaravelRequest;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

final readonly class SessionMiddleware
{
    public function __construct(private RequestExtensionInterface $requestExtension)
    {
    }

    public function handle(LaravelRequest $request, \Closure $next): mixed
    {
        $response = $next($request);

        if ($response instanceof SymfonyResponse) {
            $this->requestExtension->flash(new Request($request), new Response($response));
        }

        return $response;
    }
}
