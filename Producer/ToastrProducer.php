<?php

namespace Flasher\Toastr\Prime\Producer;

final class ToastrProducer extends \Flasher\Prime\AbstractFlasher
{
    /**
     * @inheritDoc
     */
    public function getRenderer()
    {
        return 'toastr';
    }
}
