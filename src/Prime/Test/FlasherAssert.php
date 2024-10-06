<?php

declare(strict_types=1);

namespace Flasher\Prime\Test;

use Flasher\Prime\Container\FlasherContainer;
use Flasher\Prime\EventDispatcher\Event\NotificationEvents;
use Flasher\Prime\EventDispatcher\EventListener\NotificationLoggerListener;
use Flasher\Prime\Notification\Type;
use Flasher\Prime\Test\Constraint\Notification;
use Flasher\Prime\Test\Constraint\NotificationCount;
use Flasher\Prime\Test\Constraint\NotificationMessage;
use Flasher\Prime\Test\Constraint\NotificationOption;
use Flasher\Prime\Test\Constraint\NotificationOptions;
use Flasher\Prime\Test\Constraint\NotificationTitle;
use Flasher\Prime\Test\Constraint\NotificationType;
use PHPUnit\Framework\Assert;

/**
 * FlasherAssert provides a collection of static assertion methods for testing notification states within the Flasher notification system.
 * These methods facilitate easy and readable assertions in tests, focusing on notification presence, type, content, and other attributes.
 */
final class FlasherAssert
{
    /**
     * Initializes and returns a new instance of the FlasherAssert class.
     *
     * This method serves as a starting point for chaining assertion methods in tests.
     * It provides a fluent interface that allows for more readable and expressive tests.
     * By starting assertions with `that()`, tests can emulate natural language, improving clarity.
     *
     * Usage Example:
     *
     * ```php
     * FlasherAssert::that()->hasNotifications('Custom error message if no notifications found.');
     * ```
     *
     * @return self an instance of the FlasherAssert class to allow for method chaining
     */
    public static function that(): self
    {
        return new self();
    }

    /**
     * Asserts the presence of at least one notification in the system.
     * This assertion passes if the notification system has logged any notifications, regardless of their specific attributes.
     *
     * @param string $message a custom message to display if the assertion fails
     *
     * @return self returns itself to allow method chaining
     */
    public static function hasNotifications(string $message = 'Expected at least one notification to exist.'): self
    {
        return self::fluent(static fn () => Assert::assertNotEmpty(self::getNotificationEvents()->getEnvelopes(), $message));
    }

    /**
     * Asserts that no notifications have been registered in the system.
     * Useful for tests where the absence of notifications indicates a pass condition.
     *
     * @param string $message a custom message to display if the assertion fails
     *
     * @return self returns itself to allow method chaining
     */
    public static function noNotifications(string $message = 'Expected no notifications to exist.'): self
    {
        return self::fluent(static fn () => Assert::assertEmpty(self::getNotificationEvents()->getEnvelopes(), $message));
    }

    /**
     * Asserts the existence of a notification matching specific criteria including type, message, options, and title.
     * A notification must match all provided criteria to satisfy the assertion.
     *
     * @param string               $expectedType    Expected notification type (e.g., 'success', 'error').
     * @param string|null          $expectedMessage Expected message content. Null means the message is not considered.
     * @param array<string, mixed> $expectedOptions Expected options as an associative array. Empty array means options are not considered.
     * @param string|null          $expectedTitle   Expected notification title. Null means the title is not considered.
     * @param string               $message         custom failure message
     *
     * @return self returns itself to allow method chaining
     */
    public static function withNotification(string $expectedType, ?string $expectedMessage = null, array $expectedOptions = [], ?string $expectedTitle = null, string $message = ''): self
    {
        return self::fluent(static fn () => Assert::assertThat(self::getNotificationEvents(), new Notification($expectedType, $expectedMessage, $expectedOptions, $expectedTitle), $message));
    }

    /**
     * @alias of withNotification
     *
     * Asserts the existence of a notification matching specific criteria including type, message, options, and title.
     * A notification must match all provided criteria to satisfy the assertion.
     *
     * @param string               $expectedType    Expected notification type (e.g., 'success', 'error').
     * @param string|null          $expectedMessage Expected message content. Null means the message is not considered.
     * @param array<string, mixed> $expectedOptions Expected options as an associative array. Empty array means options are not considered.
     * @param string|null          $expectedTitle   Expected notification title. Null means the title is not considered.
     * @param string               $message         custom failure message
     *
     * @return self returns itself to allow method chaining
     */
    public static function notification(string $expectedType, ?string $expectedMessage = null, array $expectedOptions = [], ?string $expectedTitle = null, string $message = ''): self
    {
        return self::withNotification($expectedType, $expectedMessage, $expectedOptions, $expectedTitle, $message);
    }

    /**
     * Asserts the total count of notifications matches an expected number.
     *
     * @param int    $expectedCount expected number of notifications
     * @param string $message       custom failure message
     *
     * @return self returns itself to allow method chaining
     */
    public static function withCount(int $expectedCount, string $message = ''): self
    {
        return self::fluent(static fn () => Assert::assertThat(self::getNotificationEvents(), new NotificationCount($expectedCount), $message));
    }

    /**
     * @alias of withCount
     *
     * Asserts the total count of notifications matches an expected number.
     *
     * @param int    $expectedCount expected number of notifications
     * @param string $message       custom failure message
     *
     * @return self returns itself to allow method chaining
     */
    public static function count(int $expectedCount, string $message = ''): self
    {
        return self::withCount($expectedCount, $message);
    }

    /**
     * Asserts the existence of at least one notification of a specific type.
     *
     * @param string $expectedType expected notification type
     * @param string $message      custom failure message
     *
     * @return self returns itself to allow method chaining
     */
    public static function withType(string $expectedType, string $message = ''): self
    {
        return self::fluent(static fn () => Assert::assertThat(self::getNotificationEvents(), new NotificationType($expectedType), $message));
    }

    /**
     * @alias of withType
     *
     * Asserts the existence of at least one notification of a specific type.
     *
     * @param string $expectedType expected notification type
     * @param string $message      custom failure message
     *
     * @return self returns itself to allow method chaining
     */
    public static function type(string $expectedType, string $message = ''): self
    {
        return self::withType($expectedType, $message);
    }

    /**
     * Asserts the presence of at least one 'success' type notification.
     *
     * @param string $message custom failure message
     *
     * @return self returns itself to allow method chaining
     */
    public static function withSuccess(string $message = ''): self
    {
        return self::fluent(static fn () => self::type(Type::SUCCESS, $message));
    }

    /**
     * @alias of withSuccess
     *
     * Asserts the presence of at least one 'success' type notification.
     *
     * @param string $message custom failure message
     *
     * @return self returns itself to allow method chaining
     */
    public static function success(string $message = ''): self
    {
        return self::withSuccess($message);
    }

    /**
     * Asserts the presence of at least one 'warning' type notification.
     *
     * @param string $message custom failure message
     *
     * @return self returns itself to allow method chaining
     */
    public static function withWarning(string $message = ''): self
    {
        return self::fluent(static fn () => self::type(Type::WARNING, $message));
    }

    /**
     * @alias of withWarning
     *
     * Asserts the presence of at least one 'warning' type notification.
     *
     * @param string $message custom failure message
     *
     * @return self returns itself to allow method chaining
     */
    public static function warning(string $message = ''): self
    {
        return self::withWarning($message);
    }

    /**
     * Asserts the presence of at least one 'error' type notification.
     *
     * @param string $message custom failure message
     *
     * @return self returns itself to allow method chaining
     */
    public static function withError(string $message = ''): self
    {
        return self::fluent(static fn () => self::type(Type::ERROR, $message));
    }

    /**
     * @alias of withError
     *
     * Asserts the presence of at least one 'error' type notification.
     *
     * @param string $message custom failure message
     *
     * @return self returns itself to allow method chaining
     */
    public static function error(string $message = ''): self
    {
        return self::withError($message);
    }

    /**
     * Asserts the presence of at least one 'info' type notification.
     *
     * @param string $message custom failure message
     *
     * @return self returns itself to allow method chaining
     */
    public static function withInfo(string $message = ''): self
    {
        return self::fluent(static fn () => self::type(Type::INFO, $message));
    }

    /**
     * @alias of withInfo
     *
     * Asserts the presence of at least one 'info' type notification.
     *
     * @param string $message custom failure message
     *
     * @return self returns itself to allow method chaining
     */
    public static function info(string $message = ''): self
    {
        return self::withInfo($message);
    }

    /**
     * Asserts the presence of a notification with a specific title.
     *
     * @param string $expectedTitle expected notification title
     * @param string $message       custom failure message
     *
     * @return self returns itself to allow method chaining
     */
    public static function withTitle(string $expectedTitle, string $message = ''): self
    {
        return self::fluent(static fn () => Assert::assertThat(self::getNotificationEvents(), new NotificationTitle($expectedTitle), $message));
    }

    /**
     * @alias of withTitle
     *
     * Asserts the presence of a notification with a specific title.
     *
     * @param string $expectedTitle expected notification title
     * @param string $message       custom failure message
     *
     * @return self returns itself to allow method chaining
     */
    public static function title(string $expectedTitle, string $message = ''): self
    {
        return self::withTitle($expectedTitle, $message);
    }

    /**
     * Asserts the presence of a notification with a specific message.
     *
     * @param string $expectedMessage expected notification message
     * @param string $message         custom failure message
     *
     * @return self returns itself to allow method chaining
     */
    public static function withMessage(string $expectedMessage, string $message = ''): self
    {
        return self::fluent(static fn () => Assert::assertThat(self::getNotificationEvents(), new NotificationMessage($expectedMessage), $message));
    }

    /**
     * @alias of withMessage
     *
     * Asserts the presence of a notification with a specific message.
     *
     * @param string $expectedMessage expected notification message
     * @param string $message         custom failure message
     *
     * @return self returns itself to allow method chaining
     */
    public static function message(string $expectedMessage, string $message = ''): self
    {
        return self::withMessage($expectedMessage, $message);
    }

    /**
     * Asserts the presence of a notification with specific options.
     *
     * @param array<string, mixed> $expectedOptions expected options as an associative array
     * @param string               $message         custom failure message
     *
     * @return self returns itself to allow method chaining
     */
    public static function withOptions(array $expectedOptions, string $message = ''): self
    {
        return self::fluent(static fn () => Assert::assertThat(self::getNotificationEvents(), new NotificationOptions($expectedOptions), $message));
    }

    /**
     * @alias of withOptions
     *
     * Asserts the presence of a notification with specific options.
     *
     * @param array<string, mixed> $expectedOptions expected options as an associative array
     * @param string               $message         custom failure message
     *
     * @return self returns itself to allow method chaining
     */
    public static function options(array $expectedOptions, string $message = ''): self
    {
        return self::withOptions($expectedOptions, $message);
    }

    /**
     * Asserts the presence of a notification with a specific option key and, optionally, a value.
     *
     * @param string $expectedKey   expected option key
     * @param mixed  $expectedValue Expected value of the option. Null or omitted to skip value check.
     * @param string $message       custom failure message
     *
     * @return self returns itself to allow method chaining
     */
    public static function withOption(string $expectedKey, mixed $expectedValue = null, string $message = ''): self
    {
        return self::fluent(static fn () => Assert::assertThat(self::getNotificationEvents(), new NotificationOption($expectedKey, $expectedValue), $message));
    }

    /**
     * @alias of withOption
     *
     * Asserts the presence of a notification with a specific option key and, optionally, a value.
     *
     * @param string $expectedKey   expected option key
     * @param mixed  $expectedValue Expected value of the option. Null or omitted to skip value check.
     * @param string $message       custom failure message
     *
     * @return self returns itself to allow method chaining
     */
    public static function option(string $expectedKey, mixed $expectedValue = null, string $message = ''): self
    {
        return self::withOption($expectedKey, $expectedValue, $message);
    }

    /**
     * A utility method used internally to wrap assertions and allow fluent interface chaining.
     * Not intended for public use.
     *
     * @param callable $callback The assertion logic encapsulated in a callable function
     *
     * @return self returns itself to enable fluent chaining of methods
     */
    private static function fluent(callable $callback): self
    {
        $callback();

        return new self();
    }

    /**
     * Fetches the NotificationEvents instance from the NotificationLoggerListener.
     * This method simplifies the process of obtaining NotificationEvents, facilitating easier assertion writing in tests.
     *
     * @return NotificationEvents the NotificationEvents instance, allowing for further inspection or assertion of notification states
     */
    public static function getNotificationEvents(): NotificationEvents
    {
        $container = FlasherContainer::getContainer();

        if (!$container->has('flasher.notification_logger_listener')) {
            return new NotificationEvents();
        }

        /** @var NotificationLoggerListener $listener */
        $listener = $container->get('flasher.notification_logger_listener');

        return $listener->getDisplayedEnvelopes();
    }
}
