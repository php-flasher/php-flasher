<?php

declare(strict_types=1);

namespace Flasher\Prime\Config;

interface ConfigInterface
{
    public function get(string $key, mixed $default = null): mixed;
}
