<?php

namespace Flasher\PFlasher\Prime\TestsProducer;

use Flasher\Prime\AbstractFlasher;

final class PnotifyProducer extends AbstractFlasher
{
    /**
     * @inheritDoc
     */
    public function getRenderer()
    {
        return 'pnotify';
    }

    /**
     * @inheritDoc
     */
    public function warning($message, $title = '', $context = array(), array $stamps = array())
    {
        return $this->render('notice', $message, $title, $context, $stamps);
    }
}
