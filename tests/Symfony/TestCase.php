<?php

namespace Flasher\Tests\Symfony;

use Flasher\Symfony\Bridge\Bridge;

class TestCase extends \Flasher\Tests\Prime\TestCase
{
    protected function getContainer()
    {
        $kernel = new FlasherKernel();
        $kernel->boot();

        if (Bridge::versionCompare('4.1', '>=')) {
            return $kernel->getContainer()->get('test.service_container');
        }

        return $kernel->getContainer();
    }
}
