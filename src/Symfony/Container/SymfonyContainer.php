<?php

declare(strict_types=1);

namespace Flasher\Symfony\Container;

use Flasher\Prime\Container\ContainerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface as BaseSymfonyContainer;

/**
 * @internal
 */
final class SymfonyContainer implements ContainerInterface
{
    public function __construct(private readonly BaseSymfonyContainer $container)
    {
    }

    public function get(string $id): ?object
    {
        return $this->container->get($id);
    }
}
