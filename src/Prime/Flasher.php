<?php

declare(strict_types=1);

namespace Flasher\Prime;

use Flasher\Prime\Factory\FlasherFactory;
use Flasher\Prime\Factory\NotificationFactoryInterface;
use Flasher\Prime\Factory\NotificationFactoryLocatorInterface;
use Flasher\Prime\Response\ResponseManagerInterface;
use Flasher\Prime\Storage\StorageManagerInterface;
use Flasher\Prime\Support\Traits\ForwardsCalls;

/**
 * Core implementation of the FlasherInterface.
 *
 * This class serves as the central hub for the notification system, managing
 * factories, storage, and response handling. It implements the Façade pattern
 * to provide a clean, simple API for client code while coordinating complex
 * subsystems behind the scenes.
 *
 * Design pattern: Façade - Provides a simplified interface to a complex system,
 * delegating to specialized components for specific functionality.
 */
final readonly class Flasher implements FlasherInterface
{
    use ForwardsCalls;

    /**
     * Current version of PHPFlasher.
     */
    public const VERSION = '2.2.0';

    /**
     * Creates a new Flasher instance.
     *
     * @param string                              $default         The default factory to use when none is specified
     * @param NotificationFactoryLocatorInterface $factoryLocator  Service locator for notification factories
     * @param ResponseManagerInterface            $responseManager Manager for rendering notifications
     * @param StorageManagerInterface             $storageManager  Manager for storing notifications
     */
    public function __construct(
        private string $default,
        private NotificationFactoryLocatorInterface $factoryLocator,
        private ResponseManagerInterface $responseManager,
        private StorageManagerInterface $storageManager,
    ) {
    }

    /**
     * {@inheritdoc}
     *
     * This implementation tries to resolve the requested factory from the
     * factory locator. If not found, it falls back to creating a generic
     * FlasherFactory with the given alias.
     */
    public function use(?string $alias): NotificationFactoryInterface
    {
        $alias = trim($alias ?: $this->default);

        if ('' === $alias) {
            throw new \InvalidArgumentException('Unable to resolve empty factory.');
        }

        if ('flasher' !== $alias && $this->factoryLocator->has($alias)) {
            return $this->factoryLocator->get($alias);
        }

        return new FlasherFactory($this->storageManager, $alias);
    }

    /**
     * {@inheritdoc}
     *
     * This is an alias for the use() method.
     */
    public function create(?string $alias): NotificationFactoryInterface
    {
        return $this->use($alias);
    }

    /**
     * {@inheritdoc}
     *
     * Delegates rendering to the response manager.
     */
    public function render(string $presenter = 'html', array $criteria = [], array $context = []): mixed
    {
        return $this->responseManager->render($presenter, $criteria, $context);
    }

    /**
     * Dynamically call methods on the default factory instance.
     *
     * This magic method enables using the Flasher instance directly with
     * notification methods like success(), error(), etc., without explicitly
     * calling use() first.
     *
     * Example:
     * ```php
     * // Instead of:
     * $flasher->use('flasher')->success('Message');
     *
     * // You can do:
     * $flasher->success('Message');
     * ```
     *
     * @param string  $method     The method name to call
     * @param mixed[] $parameters The parameters to pass to the method
     *
     * @return mixed The result of the method call
     */
    public function __call(string $method, array $parameters): mixed
    {
        return $this->forwardCallTo($this->use(null), $method, $parameters);
    }
}
