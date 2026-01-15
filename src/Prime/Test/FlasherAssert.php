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

final class FlasherAssert
{
    public static function that(): self
    {
        return new self();
    }

    public static function hasNotifications(string $message = 'Expected at least one notification to exist.'): self
    {
        return self::fluent(static fn () => Assert::assertNotEmpty(self::getNotificationEvents()->getEnvelopes(), $message));
    }

    public static function noNotifications(string $message = 'Expected no notifications to exist.'): self
    {
        return self::fluent(static fn () => Assert::assertEmpty(self::getNotificationEvents()->getEnvelopes(), $message));
    }

    /**
     * @param array<string, mixed> $expectedOptions
     */
    public static function withNotification(string $expectedType, ?string $expectedMessage = null, array $expectedOptions = [], ?string $expectedTitle = null, string $message = ''): self
    {
        return self::fluent(static fn () => Assert::assertThat(self::getNotificationEvents(), new Notification($expectedType, $expectedMessage, $expectedOptions, $expectedTitle), $message));
    }

    /**
     * @param array<string, mixed> $expectedOptions
     */
    public static function notification(string $expectedType, ?string $expectedMessage = null, array $expectedOptions = [], ?string $expectedTitle = null, string $message = ''): self
    {
        return self::withNotification($expectedType, $expectedMessage, $expectedOptions, $expectedTitle, $message);
    }

    public static function withCount(int $expectedCount, string $message = ''): self
    {
        return self::fluent(static fn () => Assert::assertThat(self::getNotificationEvents(), new NotificationCount($expectedCount), $message));
    }

    public static function count(int $expectedCount, string $message = ''): self
    {
        return self::withCount($expectedCount, $message);
    }

    public static function withType(string $expectedType, string $message = ''): self
    {
        return self::fluent(static fn () => Assert::assertThat(self::getNotificationEvents(), new NotificationType($expectedType), $message));
    }

    public static function type(string $expectedType, string $message = ''): self
    {
        return self::withType($expectedType, $message);
    }

    public static function withSuccess(string $message = ''): self
    {
        return self::fluent(static fn () => self::type(Type::SUCCESS, $message));
    }

    public static function success(string $message = ''): self
    {
        return self::withSuccess($message);
    }

    public static function withWarning(string $message = ''): self
    {
        return self::fluent(static fn () => self::type(Type::WARNING, $message));
    }

    public static function warning(string $message = ''): self
    {
        return self::withWarning($message);
    }

    public static function withError(string $message = ''): self
    {
        return self::fluent(static fn () => self::type(Type::ERROR, $message));
    }

    public static function error(string $message = ''): self
    {
        return self::withError($message);
    }

    public static function withInfo(string $message = ''): self
    {
        return self::fluent(static fn () => self::type(Type::INFO, $message));
    }

    public static function info(string $message = ''): self
    {
        return self::withInfo($message);
    }

    public static function withTitle(string $expectedTitle, string $message = ''): self
    {
        return self::fluent(static fn () => Assert::assertThat(self::getNotificationEvents(), new NotificationTitle($expectedTitle), $message));
    }

    public static function title(string $expectedTitle, string $message = ''): self
    {
        return self::withTitle($expectedTitle, $message);
    }

    public static function withMessage(string $expectedMessage, string $message = ''): self
    {
        return self::fluent(static fn () => Assert::assertThat(self::getNotificationEvents(), new NotificationMessage($expectedMessage), $message));
    }

    public static function message(string $expectedMessage, string $message = ''): self
    {
        return self::withMessage($expectedMessage, $message);
    }

    /**
     * @param array<string, mixed> $expectedOptions
     */
    public static function withOptions(array $expectedOptions, string $message = ''): self
    {
        return self::fluent(static fn () => Assert::assertThat(self::getNotificationEvents(), new NotificationOptions($expectedOptions), $message));
    }

    /**
     * @param array<string, mixed> $expectedOptions
     */
    public static function options(array $expectedOptions, string $message = ''): self
    {
        return self::withOptions($expectedOptions, $message);
    }

    public static function withOption(string $expectedKey, mixed $expectedValue = null, string $message = ''): self
    {
        return self::fluent(static fn () => Assert::assertThat(self::getNotificationEvents(), new NotificationOption($expectedKey, $expectedValue), $message));
    }

    public static function option(string $expectedKey, mixed $expectedValue = null, string $message = ''): self
    {
        return self::withOption($expectedKey, $expectedValue, $message);
    }

    private static function fluent(callable $callback): self
    {
        $callback();

        return new self();
    }

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
