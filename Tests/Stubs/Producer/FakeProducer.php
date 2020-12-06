<?php

namespace Flasher\Prime\Tests\Stubs\Factory;

use Flasher\Prime\AbstractFlasher;

class FakeProducer extends AbstractFlasher
{
    public function getRenderer()
    {
        return 'fake';
    }
}
