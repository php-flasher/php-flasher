<?php

declare(strict_types=1);

namespace Flasher\Prime;

use Flasher\Prime\Factory\FlasherFactory;
use Flasher\Prime\Factory\NotificationFactoryInterface;
use Flasher\Prime\Factory\NotificationFactoryLocatorInterface;
use Flasher\Prime\Response\ResponseManagerInterface;
use Flasher\Prime\Storage\StorageManagerInterface;
use Flasher\Prime\Support\Traits\ForwardsCalls;

final readonly class Flasher implements FlasherInterface
{
    use ForwardsCalls;

    public const VERSION = '2.1.6';

    public function __construct(
        private string $default,
        private NotificationFactoryLocatorInterface $factoryLocator,
        private ResponseManagerInterface $responseManager,
        private StorageManagerInterface $storageManager,
    ) {
    }

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

    public function create(?string $alias): NotificationFactoryInterface
    {
        return $this->use($alias);
    }

    public function render(string $presenter = 'html', array $criteria = [], array $context = []): mixed
    {
        return $this->responseManager->render($presenter, $criteria, $context);
    }

    /**
     * Dynamically call the default factory instance.
     *
     * @param mixed[] $parameters
     */
    public function __call(string $method, array $parameters): mixed
    {
        return $this->forwardCallTo($this->use(null), $method, $parameters);
    }
}
