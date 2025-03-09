<?php

declare(strict_types=1);

namespace Flasher\Prime\Http\Csp;

/**
 * NonceGeneratorInterface - Contract for generating CSP nonces.
 *
 * This interface defines the essential operation for generating secure nonces
 * (number used once) for Content Security Policy purposes. Nonces are used to
 * whitelist specific inline scripts and styles in a CSP-protected environment.
 *
 * Design pattern: Strategy - Allows for different implementations of nonce generation.
 */
interface NonceGeneratorInterface
{
    /**
     * Generates a cryptographically secure nonce.
     *
     * The generated nonce should be suitable for use in Content-Security-Policy headers
     * and should provide sufficient entropy to be secure.
     *
     * @return string The generated nonce
     */
    public function generate(): string;
}
