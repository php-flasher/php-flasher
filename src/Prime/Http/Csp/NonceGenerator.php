<?php

declare(strict_types=1);

namespace Flasher\Prime\Http\Csp;

/**
 * NonceGenerator - Default implementation for generating CSP nonces.
 *
 * This class provides a straightforward implementation for generating
 * cryptographically secure nonces using PHP's random_bytes function.
 * The nonces are encoded as hexadecimal strings for compatibility with
 * HTML attributes and CSP headers.
 *
 * Design pattern: Strategy - Implements a specific nonce generation strategy.
 */
final readonly class NonceGenerator implements NonceGeneratorInterface
{
    /**
     * {@inheritdoc}
     *
     * This implementation generates a 16-byte (128-bit) random value and
     * encodes it as a hexadecimal string.
     */
    public function generate(): string
    {
        return bin2hex(random_bytes(16));
    }
}
