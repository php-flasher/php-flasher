<?php

declare(strict_types=1);

namespace Flasher\Prime\Http\Csp;

interface NonceGeneratorInterface
{
    public function generate(): string;
}
