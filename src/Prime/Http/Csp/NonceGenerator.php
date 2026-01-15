<?php

declare(strict_types=1);

namespace Flasher\Prime\Http\Csp;

final readonly class NonceGenerator implements NonceGeneratorInterface
{
    public function generate(): string
    {
        return bin2hex(random_bytes(16));
    }
}
