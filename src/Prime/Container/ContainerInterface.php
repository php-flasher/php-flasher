<?php

declare(strict_types=1);

namespace Flasher\Prime\Container;

interface ContainerInterface
{
    public function get(string $id): ?object;
}
