<?php

declare(strict_types=1);

namespace Flasher\Prime;

use Flasher\Prime\Factory\NotificationFactoryInterface;
use Flasher\Prime\Response\Presenter\ArrayPresenter;

/**
 * FlasherInterface - The primary entry point to the notification system.
 *
 * This interface defines the contract for the notification service,
 * providing methods to access notification factories and render
 * notifications. It's the main touchpoint for client code.
 *
 * Design pattern: Façade Pattern - Provides a simplified interface
 * to the complex notification subsystems.
 *
 * @mixin \Flasher\Prime\Notification\NotificationBuilder
 *
 * @phpstan-import-type ArrayPresenterType from ArrayPresenter
 */
interface FlasherInterface
{
    /**
     * Get a notification factory instance by its alias.
     *
     * This method provides access to specific notification factories (like Toastr, SweetAlert, etc.)
     * through a unified interface. It allows you to use specialized notification features
     * while maintaining a consistent API.
     *
     * Example:
     * ```php
     * $flasher->use('toastr')->success('Message using Toastr library');
     * ```
     *
     * @param string $alias The alias of the factory to retrieve (e.g., 'toastr', 'sweetalert')
     *
     * @throws \InvalidArgumentException When the requested factory cannot be resolved
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
     * Get a notification factory instance by its alias (alias for use()).
     *
     * This method is identical to use() but provides a more intuitive name
     * for creating new notification factories.
     *
     * Example:
     * ```php
     * $flasher->create('sweetalert')->success('Message using SweetAlert library');
     * ```
     *
     * @param string $alias The alias of the factory to retrieve (e.g., 'toastr', 'sweetalert')
     *
     * @throws \InvalidArgumentException When the requested factory cannot be resolved
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
     * This method retrieves notifications from storage and formats them for display.
     * Different presenter formats can be specified (html, json, array) to support
     * various output requirements.
     *
     * Example:
     * ```php
     * // Render as HTML
     * $html = $flasher->render('html');
     *
     * // Render as JSON (for API responses)
     * $json = $flasher->render('json');
     *
     * // Render with filtering criteria
     * $errors = $flasher->render('html', ['type' => 'error']);
     * ```
     *
     * @param string               $presenter The format to render notifications in ('html', 'json', 'array')
     * @param array<string, mixed> $criteria  Optional filtering criteria for notifications
     * @param array<string, mixed> $context   Additional context or options for rendering
     *
     * @return mixed The rendered notifications in the requested format
     *
     * @phpstan-return ($presenter is 'html' ? string :
     *          ($presenter is 'array' ? ArrayPresenterType :
     *          ($presenter is 'json' ? ArrayPresenterType :
     *                      mixed)))
     */
    public function render(string $presenter = 'html', array $criteria = [], array $context = []): mixed;
}
