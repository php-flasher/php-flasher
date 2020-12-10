<?php

namespace Flasher\Notyf\Prime;

use Flasher\Prime\Factory\AbstractFactory;

/**
 * @mixin NotyfBuilder
 */
final class NotyfFactory extends AbstractFactory
{
    /**
     * @inheritDoc
     */
    public function createNotificationBuilder()
    {
        return new NotyfBuilder($this->getStorageManager(), new Notyf(), 'notyf');
    }
}
