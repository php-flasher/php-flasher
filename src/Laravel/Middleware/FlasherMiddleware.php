<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

namespace Flasher\Laravel\Middleware;

use Flasher\Laravel\Http\Request;
use Flasher\Laravel\Http\Response;
use Flasher\Prime\Http\ResponseExtension;
use Illuminate\Http\Request as LaravelRequest;
use Illuminate\Http\Response as LaravelResponse;

final class FlasherMiddleware
{
    /**
     * @var ResponseExtension
     */
    private $responseExtension;

    public function __construct(ResponseExtension $responseExtension)
    {
        $this->responseExtension = $responseExtension;
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
