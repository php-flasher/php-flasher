<?php

declare(strict_types=1);

namespace Flasher\Laravel\Middleware;

use Flasher\Laravel\Http\Request;
use Flasher\Laravel\Http\Response;
use Flasher\Prime\Http\RequestExtensionInterface;
use Illuminate\Http\Request as LaravelRequest;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

/**
 * SessionMiddleware - Middleware for processing session flash messages.
 *
 * This middleware processes Laravel's session flash messages and converts them
 * to PHPFlasher notifications, allowing seamless integration with existing code
 * that uses Laravel's built-in flash messaging.
 *
 * Design patterns:
 * - Pipeline: Participates in Laravel's middleware pipeline
 * - Adapter: Adapts Laravel flash messages to PHPFlasher notifications
 * - Transformer: Transforms one message format to another
 */
final readonly class SessionMiddleware
{
    /**
     * Creates a new SessionMiddleware instance.
     *
     * @param RequestExtensionInterface $requestExtension Service for processing request flash messages
     */
    public function __construct(private RequestExtensionInterface $requestExtension)
    {
    }

    /**
     * Handle an incoming request.
     *
     * Processes the request and response to convert Laravel flash messages
     * to PHPFlasher notifications.
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
            $this->requestExtension->flash(new Request($request), new Response($response));
        }

        return $response;
    }
}
