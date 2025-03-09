<?php

declare(strict_types=1);

namespace Flasher\Laravel\Middleware;

use Flasher\Laravel\Http\Request;
use Flasher\Laravel\Http\Response;
use Flasher\Prime\Http\ResponseExtensionInterface;
use Illuminate\Http\Request as LaravelRequest;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

/**
 * FlasherMiddleware - Middleware for injecting PHPFlasher assets into responses.
 *
 * This middleware processes outgoing HTTP responses to inject PHPFlasher's
 * JavaScript and CSS assets when needed. It's typically added to Laravel's
 * web middleware group.
 *
 * Design patterns:
 * - Pipeline: Participates in Laravel's middleware pipeline
 * - Decorator: Decorates HTTP responses with PHPFlasher assets
 * - Adapter: Adapts Laravel requests/responses to PHPFlasher interfaces
 */
final readonly class FlasherMiddleware
{
    /**
     * Creates a new FlasherMiddleware instance.
     *
     * @param ResponseExtensionInterface $responseExtension Service for extending responses with notifications
     */
    public function __construct(private ResponseExtensionInterface $responseExtension)
    {
    }

    /**
     * Handle an incoming request.
     *
     * Processes the response after the application has generated it,
     * injecting PHPFlasher assets and notifications as needed.
     *
     * @param LaravelRequest $request The incoming request
     * @param \Closure       $next    The next middleware handler
     *
     * @return mixed The processed response
     */
    public function handle(LaravelRequest $request, \Closure $next): mixed
    {
        $response = $next($request);

        if ($response instanceof SymfonyResponse) {
            $this->responseExtension->render(new Request($request), new Response($response));
        }

        return $response;
    }
}
