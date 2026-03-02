<?php

declare(strict_types=1);

namespace Flasher\Prime\Http\Csp;

use Flasher\Prime\Http\RequestInterface;
use Flasher\Prime\Http\ResponseInterface;

interface ContentSecurityPolicyHandlerInterface
{
    /**
     * @return array{csp_script_nonce: ?string, csp_style_nonce: ?string}
     */
    public function getNonces(RequestInterface $request, ?ResponseInterface $response = null): array;

    public function disableCsp(): void;

    /**
     * @return array{csp_script_nonce?: ?string, csp_style_nonce?: ?string}
     */
    public function updateResponseHeaders(RequestInterface $request, ResponseInterface $response): array;

    /**
     * Reset the handler state for long-running processes (Octane, FrankenPHP, etc.).
     */
    public function reset(): void;
}
