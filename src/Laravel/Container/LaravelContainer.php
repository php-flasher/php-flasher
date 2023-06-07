<?php

declare(strict_types=1);

namespace Flasher\Laravel\Container;

use Flasher\Prime\Container\ContainerInterface;

final class LaravelContainer implements ContainerInterface
{
    public function get(string $id): ?object
    {
        return app($id); // @phpstan-ignore-line
    }
}
