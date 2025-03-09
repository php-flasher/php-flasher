<?php

declare(strict_types=1);

namespace Flasher\Prime\Http;

/**
 * RequestInterface - Adapter interface for HTTP requests from different frameworks.
 *
 * This interface defines a common contract for request wrappers that adapt framework-specific
 * request objects to work with PHPFlasher. It provides methods for querying request properties
 * and accessing flash messages in a consistent way across different frameworks.
 *
 * Design pattern: Adapter - Provides a common interface for working with different
 * framework request objects.
 *
 * @method string getUri() Gets the URI of the request (optional method, used for path exclusion)
 */
interface RequestInterface
{
    /**
     * Checks if the request was made via XMLHttpRequest (AJAX).
     *
     * @return bool True if the request is an AJAX request
     */
    public function isXmlHttpRequest(): bool;

    /**
     * Checks if the request expects an HTML response.
     *
     * This is determined by examining the Accept header or request format.
     *
     * @return bool True if the request expects HTML
     */
    public function isHtmlRequestFormat(): bool;

    /**
     * Checks if the request has an associated session.
     *
     * @return bool True if a session is available
     */
    public function hasSession(): bool;

    /**
     * Checks if the session has been started.
     *
     * @return bool True if the session is active
     */
    public function isSessionStarted(): bool;

    /**
     * Checks if the flash bag contains messages of the specified type.
     *
     * @param string $type The flash message type
     *
     * @return bool True if messages exist for the type
     */
    public function hasType(string $type): bool;

    /**
     * Gets flash messages of the specified type.
     *
     * @param string $type The flash message type
     *
     * @return string|string[] The flash message(s) of the specified type
     */
    public function getType(string $type): string|array;

    /**
     * Removes flash messages of the specified type.
     *
     * @param string $type The flash message type to remove
     */
    public function forgetType(string $type): void;

    /**
     * Checks if the request has the specified header.
     *
     * @param string $key The header name
     *
     * @return bool True if the header exists
     */
    public function hasHeader(string $key): bool;

    /**
     * Gets the value of the specified header.
     *
     * @param string $key The header name
     *
     * @return string|null The header value, or null if it doesn't exist
     */
    public function getHeader(string $key): ?string;
}
