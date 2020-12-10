<?php

namespace Flasher\Toastr\Prime;

use Flasher\Prime\Factory\AbstractFactory;

/**
 * @mixin ToastrBuilder
 */
final class ToastrFactory extends AbstractFactory
{
    /**
     * {@inheritdoc}
     */
    public function createNotificationBuilder()
    {
        return new ToastrBuilder($this->getStorageManager(), new Toastr(), 'toastr');
    }
}
