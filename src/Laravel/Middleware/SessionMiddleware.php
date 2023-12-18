<?php

declare(strict_types=1);

namespace Flasher\Laravel\Middleware;

use Flasher\Laravel\Http\Request;
use Flasher\Laravel\Http\Response;
use Flasher\Prime\Http\RequestExtension;
use Illuminate\Http\JsonResponse as LaravelJsonResponse;
use Illuminate\Http\Request as LaravelRequest;
use Illuminate\Http\Response as LaravelResponse;

final class SessionMiddleware
{
    public function __construct(private readonly RequestExtension $requestExtension)
    {
    }

    public function handle(LaravelRequest $request, \Closure $next): mixed
    {
        $response = $next($request);

        if ($response instanceof LaravelJsonResponse || $response instanceof LaravelResponse) {
            $this->requestExtension->flash(new Request($request), new Response($response));
        }

        return $response;
    }
}
