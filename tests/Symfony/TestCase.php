<?php

declare(strict_types=1);

namespace Flasher\Tests\Symfony;

use Symfony\Component\DependencyInjection\ContainerInterface;

class TestCase extends \Flasher\Tests\Prime\TestCase
{
    protected function getContainer(): ContainerInterface
    {
        $kernel = new FlasherKernel();
        $kernel->boot();

        return $kernel->getContainer();
    }
}
