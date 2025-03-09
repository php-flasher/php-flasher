<?php

declare(strict_types=1);

namespace Flasher\Prime\Http;

/**
 * RequestExtensionInterface - Contract for request-related notification integrations.
 *
 * This interface defines the essential operations for integrating PHPFlasher with
 * HTTP request objects from various frameworks. Implementations can extract flash messages
 * from request objects (typically from session flash bags) and convert them to
 * PHPFlasher notifications.
 *
 * Design pattern: Adapter - Provides a common interface for working with different
 * framework request objects.
 */
interface RequestExtensionInterface
{
    /**
     * Processes flash messages from the request and converts them to notifications.
     *
     * This method should extract flash messages from the request (typically from session
     * flash bags), convert them to PHPFlasher notifications, and return the potentially
     * modified response.
     *
     * @param RequestInterface  $request  The framework-specific request wrapper
     * @param ResponseInterface $response The framework-specific response wrapper
     *
     * @return ResponseInterface The potentially modified response
     */
    public function flash(RequestInterface $request, ResponseInterface $response): ResponseInterface;
}
