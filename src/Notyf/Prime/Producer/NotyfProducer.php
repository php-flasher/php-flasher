<?php

namespace Flasher\Notyf\Prime\Producer;

final class NotyfProducer extends \Flasher\Prime\AbstractFlasher
{
    /**
     * @inheritDoc
     */
    public function getRenderer()
    {
        return 'notyf';
    }
}
