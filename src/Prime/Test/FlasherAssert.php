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
 * FlasherAssert - Fluent assertion library for testing notifications.
 *
 * This class provides a rich set of assertion methods for testing PHPFlasher
 * notifications in test suites. It uses a fluent interface for more readable tests
 * and integrates with PHPUnit's assertion system.
 *
 * Design patterns:
 * - Fluent Interface: Provides method chaining for readable assertions
 * - Facade: Provides a simplified interface to a complex subsystem
 * - Delegation: Delegates assertion logic to specialized constraint classes
 */
final class FlasherAssert
{
    /**
     * Initializes and returns a new instance of the FlasherAssert class.
     *
     * This method serves as a starting point for chaining assertion methods in tests.
     * It provides a fluent interface that allows for more readable and expressive tests.
     *
     * @return self A new instance for method chaining
     */
    public static function that(): self
    {
        return new self();
    }

    /**
     * Asserts the presence of at least one notification in the system.
     *
     * This assertion passes if the notification system has logged any notifications,
     * regardless of their specific attributes.
     *
     * @param string $message A custom message to display if the assertion fails
     *
     * @return self Returns itself to allow method chaining
     */
    public static function hasNotifications(string $message = 'Expected at least one notification to exist.'): self
    {
        return self::fluent(static fn () => Assert::assertNotEmpty(self::getNotificationEvents()->getEnvelopes(), $message));
    }

    /**
     * Asserts that no notifications have been registered in the system.
     *
     * Useful for tests where the absence of notifications indicates a pass condition.
     *
     * @param string $message A custom message to display if the assertion fails
     *
     * @return self Returns itself to allow method chaining
     */
    public static function noNotifications(string $message = 'Expected no notifications to exist.'): self
    {
        return self::fluent(static fn () => Assert::assertEmpty(self::getNotificationEvents()->getEnvelopes(), $message));
    }

    /**
     * Asserts the existence of a notification matching specific criteria.
     *
     * A notification must match all provided criteria to satisfy the assertion.
     *
     * @param string               $expectedType    Expected notification type (e.g., 'success', 'error')
     * @param string|null          $expectedMessage Expected message content (null to ignore)
     * @param array<string, mixed> $expectedOptions Expected options as an associative array
     * @param string|null          $expectedTitle   Expected notification title (null to ignore)
     * @param string               $message         Custom failure message
     *
     * @return self Returns itself to allow method chaining
     */
    public static function withNotification(string $expectedType, ?string $expectedMessage = null, array $expectedOptions = [], ?string $expectedTitle = null, string $message = ''): self
    {
        return self::fluent(static fn () => Assert::assertThat(self::getNotificationEvents(), new Notification($expectedType, $expectedMessage, $expectedOptions, $expectedTitle), $message));
    }

    /**
     * Alias of withNotification() - Asserts the existence of a notification matching specific criteria.
     *
     * @param string               $expectedType    Expected notification type
     * @param string|null          $expectedMessage Expected message content
     * @param array<string, mixed> $expectedOptions Expected options
     * @param string|null          $expectedTitle   Expected notification title
     * @param string               $message         Custom failure message
     *
     * @return self Returns itself to allow method chaining
     */
    public static function notification(string $expectedType, ?string $expectedMessage = null, array $expectedOptions = [], ?string $expectedTitle = null, string $message = ''): self
    {
        return self::withNotification($expectedType, $expectedMessage, $expectedOptions, $expectedTitle, $message);
    }

    /**
     * Asserts the total count of notifications matches an expected number.
     *
     * @param int    $expectedCount Expected number of notifications
     * @param string $message       Custom failure message
     *
     * @return self Returns itself to allow method chaining
     */
    public static function withCount(int $expectedCount, string $message = ''): self
    {
        return self::fluent(static fn () => Assert::assertThat(self::getNotificationEvents(), new NotificationCount($expectedCount), $message));
    }

    /**
     * Alias of withCount() - Asserts the total count of notifications.
     *
     * @param int    $expectedCount Expected number of notifications
     * @param string $message       Custom failure message
     *
     * @return self Returns itself to allow method chaining
     */
    public static function count(int $expectedCount, string $message = ''): self
    {
        return self::withCount($expectedCount, $message);
    }

    /**
     * Asserts the existence of at least one notification of a specific type.
     *
     * @param string $expectedType Expected notification type
     * @param string $message      Custom failure message
     *
     * @return self Returns itself to allow method chaining
     */
    public static function withType(string $expectedType, string $message = ''): self
    {
        return self::fluent(static fn () => Assert::assertThat(self::getNotificationEvents(), new NotificationType($expectedType), $message));
    }

    /**
     * Alias of withType() - Asserts the existence of a notification of a specific type.
     *
     * @param string $expectedType Expected notification type
     * @param string $message      Custom failure message
     *
     * @return self Returns itself to allow method chaining
     */
    public static function type(string $expectedType, string $message = ''): self
    {
        return self::withType($expectedType, $message);
    }

    /**
     * Asserts the presence of at least one 'success' type notification.
     *
     * @param string $message Custom failure message
     *
     * @return self Returns itself to allow method chaining
     */
    public static function withSuccess(string $message = ''): self
    {
        return self::fluent(static fn () => self::type(Type::SUCCESS, $message));
    }

    /**
     * Alias of withSuccess() - Asserts the presence of a 'success' notification.
     *
     * @param string $message Custom failure message
     *
     * @return self Returns itself to allow method chaining
     */
    public static function success(string $message = ''): self
    {
        return self::withSuccess($message);
    }

    /**
     * Asserts the presence of at least one 'warning' type notification.
     *
     * @param string $message Custom failure message
     *
     * @return self Returns itself to allow method chaining
     */
    public static function withWarning(string $message = ''): self
    {
        return self::fluent(static fn () => self::type(Type::WARNING, $message));
    }

    /**
     * Alias of withWarning() - Asserts the presence of a 'warning' notification.
     *
     * @param string $message Custom failure message
     *
     * @return self Returns itself to allow method chaining
     */
    public static function warning(string $message = ''): self
    {
        return self::withWarning($message);
    }

    /**
     * Asserts the presence of at least one 'error' type notification.
     *
     * @param string $message Custom failure message
     *
     * @return self Returns itself to allow method chaining
     */
    public static function withError(string $message = ''): self
    {
        return self::fluent(static fn () => self::type(Type::ERROR, $message));
    }

    /**
     * Alias of withError() - Asserts the presence of an 'error' notification.
     *
     * @param string $message Custom failure message
     *
     * @return self Returns itself to allow method chaining
     */
    public static function error(string $message = ''): self
    {
        return self::withError($message);
    }

    /**
     * Asserts the presence of at least one 'info' type notification.
     *
     * @param string $message Custom failure message
     *
     * @return self Returns itself to allow method chaining
     */
    public static function withInfo(string $message = ''): self
    {
        return self::fluent(static fn () => self::type(Type::INFO, $message));
    }

    /**
     * Alias of withInfo() - Asserts the presence of an 'info' notification.
     *
     * @param string $message Custom failure message
     *
     * @return self Returns itself to allow method chaining
     */
    public static function info(string $message = ''): self
    {
        return self::withInfo($message);
    }

    /**
     * Asserts the presence of a notification with a specific title.
     *
     * @param string $expectedTitle Expected notification title
     * @param string $message       Custom failure message
     *
     * @return self Returns itself to allow method chaining
     */
    public static function withTitle(string $expectedTitle, string $message = ''): self
    {
        return self::fluent(static fn () => Assert::assertThat(self::getNotificationEvents(), new NotificationTitle($expectedTitle), $message));
    }

    /**
     * Alias of withTitle() - Asserts the presence of a notification with specific title.
     *
     * @param string $expectedTitle Expected notification title
     * @param string $message       Custom failure message
     *
     * @return self Returns itself to allow method chaining
     */
    public static function title(string $expectedTitle, string $message = ''): self
    {
        return self::withTitle($expectedTitle, $message);
    }

    /**
     * Asserts the presence of a notification with a specific message.
     *
     * @param string $expectedMessage Expected notification message
     * @param string $message         Custom failure message
     *
     * @return self Returns itself to allow method chaining
     */
    public static function withMessage(string $expectedMessage, string $message = ''): self
    {
        return self::fluent(static fn () => Assert::assertThat(self::getNotificationEvents(), new NotificationMessage($expectedMessage), $message));
    }

    /**
     * Alias of withMessage() - Asserts the presence of a notification with specific message.
     *
     * @param string $expectedMessage Expected notification message
     * @param string $message         Custom failure message
     *
     * @return self Returns itself to allow method chaining
     */
    public static function message(string $expectedMessage, string $message = ''): self
    {
        return self::withMessage($expectedMessage, $message);
    }

    /**
     * Asserts the presence of a notification with specific options.
     *
     * @param array<string, mixed> $expectedOptions Expected options as an associative array
     * @param string               $message         Custom failure message
     *
     * @return self Returns itself to allow method chaining
     */
    public static function withOptions(array $expectedOptions, string $message = ''): self
    {
        return self::fluent(static fn () => Assert::assertThat(self::getNotificationEvents(), new NotificationOptions($expectedOptions), $message));
    }

    /**
     * Alias of withOptions() - Asserts the presence of a notification with specific options.
     *
     * @param array<string, mixed> $expectedOptions Expected options
     * @param string               $message         Custom failure message
     *
     * @return self Returns itself to allow method chaining
     */
    public static function options(array $expectedOptions, string $message = ''): self
    {
        return self::withOptions($expectedOptions, $message);
    }

    /**
     * Asserts the presence of a notification with a specific option key and value.
     *
     * @param string $expectedKey   Expected option key
     * @param mixed  $expectedValue Expected option value (null to check only key existence)
     * @param string $message       Custom failure message
     *
     * @return self Returns itself to allow method chaining
     */
    public static function withOption(string $expectedKey, mixed $expectedValue = null, string $message = ''): self
    {
        return self::fluent(static fn () => Assert::assertThat(self::getNotificationEvents(), new NotificationOption($expectedKey, $expectedValue), $message));
    }

    /**
     * Alias of withOption() - Asserts notification has a specific option.
     *
     * @param string $expectedKey   Expected option key
     * @param mixed  $expectedValue Expected option value
     * @param string $message       Custom failure message
     *
     * @return self Returns itself to allow method chaining
     */
    public static function option(string $expectedKey, mixed $expectedValue = null, string $message = ''): self
    {
        return self::withOption($expectedKey, $expectedValue, $message);
    }

    /**
     * Internal utility method for fluent interface implementation.
     *
     * This method executes a callback and returns a new instance of FlasherAssert
     * to allow method chaining in a fluent interface style.
     *
     * @param callable $callback The assertion logic to execute
     *
     * @return self A new instance for method chaining
     */
    private static function fluent(callable $callback): self
    {
        $callback();

        return new self();
    }

    /**
     * Fetches the NotificationEvents instance for assertion.
     *
     * This method retrieves notification events from the NotificationLoggerListener
     * service, which tracks notifications that were displayed.
     *
     * @return NotificationEvents Collection of notification events for assertion
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
