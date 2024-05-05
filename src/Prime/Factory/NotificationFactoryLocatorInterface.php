<?php

declare(strict_types=1);

namespace Flasher\Prime\Factory;

interface NotificationFactoryLocatorInterface
{
    public function has(string $id): bool;

    /**
     * @phpstan-return ($id is 'flasher' ? \Flasher\Prime\Factory\FlasherFactoryInterface :
     *          ($id is 'noty' ? \Flasher\Noty\Prime\NotyInterface :
     *          ($id is 'notyf' ? \Flasher\Notyf\Prime\NotyfInterface :
     *          ($id is 'sweetalert' ? \Flasher\SweetAlert\Prime\SweetAlertInterface :
     *          ($id is 'toastr' ? \Flasher\Toastr\Prime\ToastrInterface :
     *                  \Flasher\Prime\Factory\NotificationFactoryInterface)))))
     */
    public function get(string $id): NotificationFactoryInterface;
}
