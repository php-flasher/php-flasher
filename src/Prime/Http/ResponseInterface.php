<?php

declare(strict_types=1);

namespace Flasher\Prime\Http;

/**
 * ResponseInterface - Adapter interface for HTTP responses from different frameworks.
 *
 * This interface defines a common contract for response wrappers that adapt framework-specific
 * response objects to work with PHPFlasher. It provides methods for inspecting response
 * properties and modifying content in a consistent way across different frameworks.
 *
 * Design pattern: Adapter - Provides a common interface for working with different
 * framework response objects.
 */
interface ResponseInterface
{
    /**
     * Checks if the response is a redirection.
     *
     * @return bool True if the response is a redirect (3XX status code)
     */
    public function isRedirection(): bool;

    /**
     * Checks if the response contains JSON content.
     *
     * @return bool True if the response is JSON
     */
    public function isJson(): bool;

    /**
     * Checks if the response contains HTML content.
     *
     * @return bool True if the response is HTML
     */
    public function isHtml(): bool;

    /**
     * Checks if the response is a file download/attachment.
     *
     * @return bool True if the response is an attachment
     */
    public function isAttachment(): bool;

    /**
     * Checks if the response represents a successful operation.
     *
     * @return bool True if the response has a 2XX status code
     */
    public function isSuccessful(): bool;

    /**
     * Gets the response content.
     *
     * @return string The response content
     */
    public function getContent(): string;

    /**
     * Sets the response content.
     *
     * @param string $content The new response content
     */
    public function setContent(string $content): void;

    /**
     * Checks if the response has the specified header.
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

    /**
     * Sets the value of the specified header.
     *
     * @param string               $key    The header name
     * @param string|string[]|null $values The header value(s)
     */
    public function setHeader(string $key, string|array|null $values): void;

    /**
     * Removes the specified header.
     *
     * @param string $key The header name
     */
    public function removeHeader(string $key): void;
}
