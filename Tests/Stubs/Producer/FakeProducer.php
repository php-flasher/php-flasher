<?php

namespace Flasher\Prime\Tests\Stubs\Producer;

use Flasher\Prime\AbstractFlasher;

class FakeProducer extends AbstractFlasher
{
    public function getRenderer()
    {
        return 'fake';
    }
}
