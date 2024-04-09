<?php

declare(strict_types=1);

namespace Flasher\Prime\Http\Csp;

use Flasher\Prime\Http\RequestInterface;
use Flasher\Prime\Http\ResponseInterface;

interface ContentSecurityPolicyHandlerInterface
{
    /**
     * Returns an array of nonces to be used in html templates and Content-Security-Policy headers.
     *
     * Nonce can be provided by;
     *  - The request - In case HTML content is fetched via AJAX and inserted in DOM, it must use the same nonce as origin
     *  - The response -  A call to getNonces() has already been done previously. Same nonce are returned
     *  - They are otherwise randomly generated
     *
     * @return array{csp_script_nonce: ?string, csp_style_nonce: ?string}
     */
    public function getNonces(RequestInterface $request, ?ResponseInterface $response = null): array;

    /**
     * Disables Content-Security-Policy.
     *
     * All related headers will be removed.
     */
    public function disableCsp(): void;

    /**
     * Cleanup temporary headers and updates Content-Security-Policy headers.
     *
     * @return array{csp_script_nonce?: ?string, csp_style_nonce?: ?string} Nonces used in Content-Security-Policy header
     */
    public function updateResponseHeaders(RequestInterface $request, ResponseInterface $response): array;
}
