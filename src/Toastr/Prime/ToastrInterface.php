<?php

declare(strict_types=1);

namespace Flasher\Toastr\Prime;

use Flasher\Prime\Factory\NotificationFactoryInterface;

/**
 * @mixin \Flasher\Toastr\Prime\ToastrBuilder
 */
interface ToastrInterface extends NotificationFactoryInterface
{
}
