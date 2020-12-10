<?php

namespace Flasher\Noty\Prime;

use Flasher\Prime\Factory\AbstractFactory;

/**
 * @mixin NotyBuilder
 */
final class NotyFactory extends AbstractFactory
{
    /**
     * @inheritDoc
     */
    public function createNotificationBuilder()
    {
        return new NotyBuilder($this->getStorageManager(), new Noty(), 'noty');
    }
}
