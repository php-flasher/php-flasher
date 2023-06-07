<?php

declare(strict_types=1);

namespace Flasher\Laravel\Middleware;

use Flasher\Laravel\Http\Request;
use Flasher\Laravel\Http\Response;
use Flasher\Prime\Http\ResponseExtension;
use Illuminate\Http\Request as LaravelRequest;
use Illuminate\Http\Response as LaravelResponse;

final class FlasherMiddleware
{
    public function __construct(private readonly ResponseExtension $responseExtension)
    {
    }

    /**
     * @return LaravelResponse
     */
    public function handle(LaravelRequest $request, \Closure $next)
    {
        /** @var LaravelResponse $response */
        $response = $next($request);

        $this->responseExtension->render(new Request($request), new Response($response));

        return $response;
    }
}
