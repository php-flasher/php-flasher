<?php

declare(strict_types=1);

namespace Flasher\Prime;

use Flasher\Prime\Factory\NotificationFactoryInterface;
use Flasher\Prime\Response\Presenter\ArrayPresenter;

/**
 * @mixin \Flasher\Prime\Notification\NotificationBuilder
 *
 * @phpstan-import-type ArrayPresenterType from ArrayPresenter
 */
interface FlasherInterface
{
    /**
     * @phpstan-return ($alias is 'flasher' ? \Flasher\Prime\Factory\FlasherFactoryInterface :
     *          ($alias is 'noty' ? \Flasher\Noty\Prime\NotyInterface :
     *          ($alias is 'notyf' ? \Flasher\Notyf\Prime\NotyfInterface :
     *          ($alias is 'sweetalert' ? \Flasher\SweetAlert\Prime\SweetAlertInterface :
     *          ($alias is 'toastr' ? \Flasher\Toastr\Prime\ToastrInterface :
     *                  \Flasher\Prime\Factory\NotificationFactoryInterface)))))
     */
    public function use(string $alias): NotificationFactoryInterface;

    /**
     * @phpstan-return ($alias is 'flasher' ? \Flasher\Prime\Factory\FlasherFactoryInterface :
     *          ($alias is 'noty' ? \Flasher\Noty\Prime\NotyInterface :
     *          ($alias is 'notyf' ? \Flasher\Notyf\Prime\NotyfInterface :
     *          ($alias is 'sweetalert' ? \Flasher\SweetAlert\Prime\SweetAlertInterface :
     *          ($alias is 'toastr' ? \Flasher\Toastr\Prime\ToastrInterface :
     *                  \Flasher\Prime\Factory\NotificationFactoryInterface)))))
     */
    public function create(string $alias): NotificationFactoryInterface;

    /**
     * @param array<string, mixed> $criteria
     * @param array<string, mixed> $context
     *
     * @phpstan-return ($presenter is 'html' ? string :
     *          ($presenter is 'array' ? ArrayPresenterType :
     *          ($presenter is 'json' ? ArrayPresenterType :
     *                      mixed)))
     */
    public function render(string $presenter = 'html', array $criteria = [], array $context = []): mixed;
}
