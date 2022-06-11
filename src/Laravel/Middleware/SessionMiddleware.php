<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

namespace Flasher\Laravel\Middleware;

use Closure;
use Flasher\Laravel\Http\Request;
use Flasher\Laravel\Http\Response;
use Flasher\Prime\Http\RequestExtension;
use Illuminate\Http\Request as LaravelRequest;
use Illuminate\Http\Response as LaravelResponse;

final class SessionMiddleware
{
    /**
     * @var RequestExtension
     */
    private $requestExtension;

    public function __construct(RequestExtension $requestExtension)
    {
        $this->requestExtension = $requestExtension;
    }

    /**
     * @return LaravelResponse
     */
    public function handle(LaravelRequest $request, Closure $next)
    {
        /** @var LaravelResponse $response */
        $response = $next($request);

        $this->requestExtension->flash(new Request($request), new Response($response));

        return $response;
    }
}
