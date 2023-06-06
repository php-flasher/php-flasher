<?php

namespace Flasher\Symfony\Container;

use Flasher\Prime\Container\ContainerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface as BaseSymfonyContainer;

final class SymfonyContainer implements ContainerInterface
{
    /** @var BaseSymfonyContainer */
    private $container;

    public function __construct(BaseSymfonyContainer $container)
    {
        $this->container = $container;
    }

    public function get($id)
    {
        return $this->container->get($id);
    }
}
