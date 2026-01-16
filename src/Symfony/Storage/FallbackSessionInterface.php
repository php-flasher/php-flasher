<?php

declare(strict_types=1);

namespace Flasher\Symfony\Storage;

interface FallbackSessionInterface
{
    public function get(string $name, mixed $default = null): mixed;

    public function set(string $name, mixed $value): void;
}
