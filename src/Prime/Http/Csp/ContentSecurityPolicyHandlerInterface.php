<?php

declare(strict_types=1);

namespace Flasher\Prime\Http\Csp;

use Flasher\Prime\Http\RequestInterface;
use Flasher\Prime\Http\ResponseInterface;

/**
 * ContentSecurityPolicyHandlerInterface - Contract for handling Content Security Policy.
 *
 * This interface defines operations for managing Content Security Policy (CSP) headers
 * and nonces, which are necessary for securely injecting JavaScript and CSS into HTML pages.
 * It ensures that PHPFlasher's injected content doesn't violate the site's CSP.
 *
 * Design pattern: Strategy - Defines a common interface for CSP handling strategies.
 */
interface ContentSecurityPolicyHandlerInterface
{
    /**
     * Returns an array of nonces to be used in HTML templates and Content-Security-Policy headers.
     *
     * Nonce can be provided by:
     *  - The request - In case HTML content is fetched via AJAX and inserted in DOM, it must use the same nonce as origin
     *  - The response -  A call to getNonces() has already been done previously. Same nonce are returned
     *  - They are otherwise randomly generated
     *
     * @param RequestInterface       $request  The current request
     * @param ResponseInterface|null $response The current response (optional)
     *
     * @return array{csp_script_nonce: ?string, csp_style_nonce: ?string} Array with script and style nonces
     */
    public function getNonces(RequestInterface $request, ?ResponseInterface $response = null): array;

    /**
     * Disables Content-Security-Policy.
     *
     * All related headers will be removed. This is useful in environments where CSP
     * is not needed or when debugging.
     */
    public function disableCsp(): void;

    /**
     * Cleanup temporary headers and updates Content-Security-Policy headers.
     *
     * This method modifies CSP headers in the response to allow PHPFlasher's
     * JavaScript and CSS to execute without being blocked by CSP.
     *
     * @param RequestInterface  $request  The current request
     * @param ResponseInterface $response The current response
     *
     * @return array{csp_script_nonce?: ?string, csp_style_nonce?: ?string} Nonces used in Content-Security-Policy header
     */
    public function updateResponseHeaders(RequestInterface $request, ResponseInterface $response): array;
}
