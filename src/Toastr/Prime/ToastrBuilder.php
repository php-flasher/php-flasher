<?php

declare(strict_types=1);

namespace Flasher\Toastr\Prime;

use Flasher\Prime\Notification\Envelope;
use Flasher\Prime\Notification\NotificationBuilder;

/**
 * ToastrBuilder - Builder implementation for Toastr.js notifications.
 *
 * This class provides a comprehensive fluent interface for configuring Toastr.js
 * notifications. It extends the core notification builder with Toastr's
 * extensive range of options, including positioning, animation effects,
 * timing, and interaction behaviors.
 *
 * Design patterns:
 * - Builder: Provides a fluent interface for constructing complex objects
 * - Fluent Interface: Methods return $this for method chaining
 * - Type Safety: Uses PHPStan annotations for compile-time type checking
 *
 * @phpstan-type NotificationType "success"|"info"|"warning"|"error"
 * @phpstan-type OptionsType array{
 *     closeButton?: bool,
 *     closeClass?: string,
 *     closeDuration?: int,
 *     closeEasing?: string,
 *     closeHtml?: string,
 *     closeMethod?: string,
 *     closeOnHover?: bool,
 *     containerId?: string,
 *     debug?: bool,
 *     escapeHtml?: bool,
 *     extendedTimeOut?: int,
 *     hideDuration?: int,
 *     hideEasing?: string,
 *     hideMethod?: string,
 *     iconClass?: string,
 *     messageClass?: string,
 *     newestOnTop?: bool,
 *     onHidden?: string,
 *     onShown?: string,
 *     positionClass?: "toast-top-right"|"toast-top-center"|"toast-bottom-center"|"toast-top-full-width"|"toast-bottom-full-width"|"toast-top-left"|"toast-bottom-right"|"toast-bottom-left",
 *     preventDuplicates?: bool,
 *     progressBar?: bool,
 *     progressClass?: string,
 *     rtl?: bool,
 *     showDuration?: int,
 *     showEasing?: string,
 *     showMethod?: string,
 *     tapToDismiss?: bool,
 *     target?: string,
 *     timeOut?: int,
 *     titleClass?: string,
 *     toastClass?: string,
 * }
 */
final class ToastrBuilder extends NotificationBuilder
{
    /**
     * Sets the notification type with Toastr-specific type checking.
     *
     * @phpstan-param NotificationType $type The notification type
     *
     * @return static The builder instance
     */
    public function type(string $type): static
    {
        return parent::type($type);
    }

    /**
     * Creates a success notification with Toastr-specific options.
     *
     * @param string      $message The notification message
     * @param OptionsType $options Toastr-specific options
     * @param string|null $title   The notification title
     *
     * @return Envelope The notification envelope
     */
    public function success(string $message, array $options = [], ?string $title = null): Envelope
    {
        return parent::success($message, $options, $title);
    }

    /**
     * Creates an error notification with Toastr-specific options.
     *
     * @param string      $message The notification message
     * @param OptionsType $options Toastr-specific options
     * @param string|null $title   The notification title
     *
     * @return Envelope The notification envelope
     */
    public function error(string $message, array $options = [], ?string $title = null): Envelope
    {
        return parent::error($message, $options, $title);
    }

    /**
     * Creates an info notification with Toastr-specific options.
     *
     * @param string      $message The notification message
     * @param OptionsType $options Toastr-specific options
     * @param string|null $title   The notification title
     *
     * @return Envelope The notification envelope
     */
    public function info(string $message, array $options = [], ?string $title = null): Envelope
    {
        return parent::info($message, $options, $title);
    }

    /**
     * Creates a warning notification with Toastr-specific options.
     *
     * @param string      $message The notification message
     * @param OptionsType $options Toastr-specific options
     * @param string|null $title   The notification title
     *
     * @return Envelope The notification envelope
     */
    public function warning(string $message, array $options = [], ?string $title = null): Envelope
    {
        return parent::warning($message, $options, $title);
    }

    /**
     * Creates a notification of the specified type with Toastr-specific options.
     *
     * @phpstan-param NotificationType|null $type    The notification type
     * @phpstan-param OptionsType           $options Toastr-specific options
     *
     * @param string|null $type    The notification type
     * @param string|null $message The notification message
     * @param array       $options Toastr-specific options
     * @param string|null $title   The notification title
     *
     * @return Envelope The notification envelope
     */
    public function flash(?string $type = null, ?string $message = null, array $options = [], ?string $title = null): Envelope
    {
        return parent::flash($type, $message, $options, $title);
    }

    /**
     * Sets notification options with Toastr-specific type checking.
     *
     * @param OptionsType $options The notification options
     * @param bool        $append  Whether to append or replace existing options
     *
     * @return static The builder instance
     */
    public function options(array $options, bool $append = true): static
    {
        return parent::options($options, $append);
    }

    /**
     * Sets a specific notification option with Toastr-specific type checking.
     *
     * @template T of OptionsType
     * @template K of key-of<T>
     *
     * @phpstan-param K $name
     * @phpstan-param T[K] $value
     *
     * @param string $name  The option name
     * @param mixed  $value The option value
     *
     * @return static The builder instance
     */
    public function option(string $name, mixed $value): static
    {
        return parent::option($name, $value);
    }

    /**
     * Enables a close button on the notification.
     *
     * @param bool $closeButton Whether to show a close button
     *
     * @return self The builder instance
     */
    public function closeButton(bool $closeButton = true): self
    {
        $this->option('closeButton', $closeButton);

        return $this;
    }

    /**
     * Sets the CSS class for the close button.
     *
     * @param string $closeClass The CSS class name
     *
     * @return self The builder instance
     */
    public function closeClass(string $closeClass): self
    {
        $this->option('closeClass', $closeClass);

        return $this;
    }

    /**
     * Sets the duration for the close animation in milliseconds.
     *
     * @param int $closeDuration Duration in milliseconds
     *
     * @return self The builder instance
     */
    public function closeDuration(int $closeDuration): self
    {
        $this->option('closeDuration', $closeDuration);

        return $this;
    }

    /**
     * Sets the easing function for the close animation.
     *
     * @param string $closeEasing Easing function name
     *
     * @return self The builder instance
     */
    public function closeEasing(string $closeEasing): self
    {
        $this->option('closeEasing', $closeEasing);

        return $this;
    }

    /**
     * Overrides the close button's HTML markup.
     *
     * @param string $closeHtml HTML content for the close button
     *
     * @return self The builder instance
     */
    public function closeHtml(string $closeHtml): self
    {
        $this->option('closeHtml', $closeHtml);

        return $this;
    }

    /**
     * Sets the method for the close animation.
     *
     * @param string $closeMethod Animation method name
     *
     * @return self The builder instance
     */
    public function closeMethod(string $closeMethod): self
    {
        $this->option('closeMethod', $closeMethod);

        return $this;
    }

    /**
     * Sets whether the notification extends timeout on hover.
     *
     * @param bool $closeOnHover Whether to pause timeout on hover
     *
     * @return self The builder instance
     */
    public function closeOnHover(bool $closeOnHover = true): self
    {
        $this->option('closeOnHover', $closeOnHover);

        return $this;
    }

    /**
     * Sets the container ID for the notification.
     *
     * @param string $containerId The container element ID
     *
     * @return self The builder instance
     */
    public function containerId(string $containerId): self
    {
        $this->option('containerId', $containerId);

        return $this;
    }

    /**
     * Enables debug mode for the notification.
     *
     * @param bool $debug Whether to enable debug mode
     *
     * @return self The builder instance
     */
    public function debug(bool $debug = true): self
    {
        $this->option('debug', $debug);

        return $this;
    }

    /**
     * Sets whether to escape HTML in the title and message.
     *
     * This is important for security when displaying user-generated content.
     *
     * @param bool $escapeHtml Whether to escape HTML content
     *
     * @return self The builder instance
     */
    public function escapeHtml(bool $escapeHtml = true): self
    {
        $this->option('escapeHtml', $escapeHtml);

        return $this;
    }

    /**
     * Sets the extended timeout duration when a user hovers over the notification.
     *
     * @param int $extendedTimeOut Duration in milliseconds
     *
     * @return self The builder instance
     */
    public function extendedTimeOut(int $extendedTimeOut): self
    {
        $this->option('extendedTimeOut', $extendedTimeOut);

        return $this;
    }

    /**
     * Sets the duration for the hiding animation in milliseconds.
     *
     * @param int $hideDuration Duration in milliseconds
     *
     * @return self The builder instance
     */
    public function hideDuration(int $hideDuration): self
    {
        $this->option('hideDuration', $hideDuration);

        return $this;
    }

    /**
     * Sets the easing function for the hide animation.
     *
     * @param string $hideEasing Easing function name (e.g., 'swing', 'linear')
     *
     * @return self The builder instance
     */
    public function hideEasing(string $hideEasing): self
    {
        $this->option('hideEasing', $hideEasing);

        return $this;
    }

    /**
     * Sets the method for the hide animation.
     *
     * @param string $hideMethod Animation method (e.g., 'fadeOut', 'slideUp')
     *
     * @return self The builder instance
     */
    public function hideMethod(string $hideMethod): self
    {
        $this->option('hideMethod', $hideMethod);

        return $this;
    }

    /**
     * Sets the CSS class for the icon.
     *
     * @param string $iconClass The CSS class name
     *
     * @return self The builder instance
     */
    public function iconClass(string $iconClass): self
    {
        $this->option('iconClass', $iconClass);

        return $this;
    }

    /**
     * Sets the CSS class for the message element.
     *
     * @param string $messageClass The CSS class name
     *
     * @return self The builder instance
     */
    public function messageClass(string $messageClass): self
    {
        $this->option('messageClass', $messageClass);

        return $this;
    }

    /**
     * Sets whether to show newest toasts at the bottom (default) or top.
     *
     * @param bool $newestOnTop Whether to show newest toasts at top
     *
     * @return self The builder instance
     */
    public function newestOnTop(bool $newestOnTop = true): self
    {
        $this->option('newestOnTop', $newestOnTop);

        return $this;
    }

    /**
     * Sets a callback function to execute when the toast is hidden.
     *
     * @param string $onHidden JavaScript callback function
     *
     * @return self The builder instance
     */
    public function onHidden(string $onHidden): self
    {
        $this->option('onHidden', $onHidden);

        return $this;
    }

    /**
     * Sets a callback function to execute when the toast is shown.
     *
     * @param string $onShown JavaScript callback function
     *
     * @return self The builder instance
     */
    public function onShown(string $onShown): self
    {
        $this->option('onShown', $onShown);

        return $this;
    }

    /**
     * Sets the position class for the toast.
     *
     * @phpstan-param OptionsType['positionClass'] $positionClass Position class name
     *
     * @param string $positionClass Position class (e.g., 'toast-top-right')
     *
     * @return self The builder instance
     */
    public function positionClass(string $positionClass): self
    {
        $this->option('positionClass', $positionClass);

        return $this;
    }

    /**
     * Sets whether to prevent duplicate toasts.
     *
     * When enabled, identical toasts won't stack but replace previous ones.
     * Duplicates are matched based on their message content.
     *
     * @param bool $preventDuplicates Whether to prevent duplicates
     *
     * @return self The builder instance
     */
    public function preventDuplicates(bool $preventDuplicates = true): self
    {
        $this->option('preventDuplicates', $preventDuplicates);

        return $this;
    }

    /**
     * Sets whether to show a progress bar indicating the toast's timeout.
     *
     * @param bool $progressBar Whether to show the progress bar
     *
     * @return self The builder instance
     */
    public function progressBar(bool $progressBar = true): self
    {
        $this->option('progressBar', $progressBar);

        return $this;
    }

    /**
     * Sets the CSS class for the progress bar.
     *
     * @param string $progressClass The CSS class name
     *
     * @return self The builder instance
     */
    public function progressClass(string $progressClass): self
    {
        $this->option('progressClass', $progressClass);

        return $this;
    }

    /**
     * Sets whether to display the toast in RTL (right-to-left) mode.
     *
     * This is useful for right-to-left languages like Arabic, Hebrew, etc.
     *
     * @param bool $rtl Whether to enable RTL mode
     *
     * @return self The builder instance
     */
    public function rtl(bool $rtl = true): self
    {
        $this->option('rtl', $rtl);

        return $this;
    }

    /**
     * Sets the duration for the show animation in milliseconds.
     *
     * @param int $showDuration Duration in milliseconds
     *
     * @return self The builder instance
     */
    public function showDuration(int $showDuration): self
    {
        $this->option('showDuration', $showDuration);

        return $this;
    }

    /**
     * Sets the easing function for the show animation.
     *
     * @param string $showEasing Easing function name (e.g., 'swing', 'linear')
     *
     * @return self The builder instance
     */
    public function showEasing(string $showEasing): self
    {
        $this->option('showEasing', $showEasing);

        return $this;
    }

    /**
     * Sets the method for the show animation.
     *
     * @param string $showMethod Animation method (e.g., 'fadeIn', 'slideDown')
     *
     * @return self The builder instance
     */
    public function showMethod(string $showMethod): self
    {
        $this->option('showMethod', $showMethod);

        return $this;
    }

    /**
     * Sets whether clicking on the toast dismisses it.
     *
     * @param bool $tapToDismiss Whether to enable tap to dismiss
     *
     * @return self The builder instance
     */
    public function tapToDismiss(bool $tapToDismiss = true): self
    {
        $this->option('tapToDismiss', $tapToDismiss);

        return $this;
    }

    /**
     * Sets the target element for the toast.
     *
     * @param string $target Target element selector
     *
     * @return self The builder instance
     */
    public function target(string $target): self
    {
        $this->option('target', $target);

        return $this;
    }

    /**
     * Sets how long the toast will display without user interaction.
     *
     * @param int      $timeOut         Duration in milliseconds
     * @param int|null $extendedTimeOut Optional extended timeout duration
     *
     * @return self The builder instance
     */
    public function timeOut(int $timeOut, ?int $extendedTimeOut = null): self
    {
        $this->option('timeOut', $timeOut);

        if (null !== $extendedTimeOut) {
            $this->extendedTimeOut($extendedTimeOut);
        }

        return $this;
    }

    /**
     * Sets the CSS class for the title element.
     *
     * @param string $titleClass The CSS class name
     *
     * @return self The builder instance
     */
    public function titleClass(string $titleClass): self
    {
        $this->option('titleClass', $titleClass);

        return $this;
    }

    /**
     * Sets the CSS class for the toast container.
     *
     * @param string $toastClass The CSS class name
     *
     * @return self The builder instance
     */
    public function toastClass(string $toastClass): self
    {
        $this->option('toastClass', $toastClass);

        return $this;
    }

    /**
     * Makes the notification persistent (prevents auto-hiding).
     *
     * This is a convenience method that sets both timeOut and extendedTimeOut to 0.
     *
     * @return self The builder instance
     */
    public function persistent(): self
    {
        $this->timeOut(0);
        $this->extendedTimeOut(0);

        return $this;
    }
}
