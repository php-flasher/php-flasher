<?php

namespace Flasher\Notyf\Prime\Factory;

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
