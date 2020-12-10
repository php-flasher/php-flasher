<?php

namespace Flasher\SweetAlert\Prime;

use Flasher\Prime\Factory\AbstractFactory;

/**
 * @mixin SweetAlertBuilder
 */
final class SweetAlertFactory extends AbstractFactory
{
    /**
     * @inheritDoc
     */
    public function createNotificationBuilder()
    {
        return new SweetAlertBuilder($this->getStorageManager(), new SweetAlert(), 'sweet_alert');
    }
}
