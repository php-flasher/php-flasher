<?php

declare(strict_types=1);

namespace Flasher\Prime;

use Flasher\Prime\Factory\NotificationFactoryInterface;
use Flasher\Prime\Response\Presenter\ArrayPresenter;

/**
 * @mixin \Flasher\Prime\Notification\FlasherBuilder
 *
 * @phpstan-import-type ArrayPresenterType from ArrayPresenter
 */
interface FlasherInterface
{
    /**
     * Get a notification factory instance.
     *
     * @throws \InvalidArgumentException
     *
     * @phpstan-return ($alias is 'flasher' ? \Flasher\Prime\Factory\FlasherFactoryInterface :
     *          ($alias is 'noty' ? \Flasher\Noty\Prime\NotyInterface :
     *          ($alias is 'notyf' ? \Flasher\Notyf\Prime\NotyfInterface :
     *          ($alias is 'sweetalert' ? \Flasher\SweetAlert\Prime\SweetAlertInterface :
     *          ($alias is 'toastr' ? \Flasher\Toastr\Prime\ToastrInterface :
     *                  \Flasher\Prime\Factory\NotificationFactoryInterface)))))
     */
    public function use(string $alias): NotificationFactoryInterface;

    /**
     * Get a notification factory instance.
     *
     * @throws \InvalidArgumentException
     *
     * @phpstan-return ($alias is 'flasher' ? \Flasher\Prime\Factory\FlasherFactoryInterface :
     *          ($alias is 'noty' ? \Flasher\Noty\Prime\NotyInterface :
     *          ($alias is 'notyf' ? \Flasher\Notyf\Prime\NotyfInterface :
     *          ($alias is 'sweetalert' ? \Flasher\SweetAlert\Prime\SweetAlertInterface :
     *          ($alias is 'toastr' ? \Flasher\Toastr\Prime\ToastrInterface :
     *                  \Flasher\Prime\Factory\NotificationFactoryInterface)))))
     */
    public function create(string $alias): NotificationFactoryInterface;

    /**
     * Renders the flash notifications based on the specified criteria, presenter, and context.
     *
     * @param array<string, mixed> $criteria  the criteria to filter the notifications
     * @param string|"html"|"json" $presenter The presenter format for rendering the notifications (e.g., 'html', 'json').
     * @param array<string, mixed> $context   additional context or options for rendering
     *
     * @phpstan-return ($presenter is 'html' ? string :
     *          ($presenter is 'array' ? ArrayPresenterType :
     *          ($presenter is 'json' ? ArrayPresenterType :
     *                      mixed)))
     */
    public function render(string $presenter = 'html', array $criteria = [], array $context = []): mixed;
}
