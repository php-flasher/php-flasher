<?php

namespace Flasher\Prime;

use Flasher\Prime\Factory\NotificationFactory;
use Flasher\Prime\Factory\NotificationFactoryInterface;
use Flasher\Prime\Response\ResponseManager;
use Flasher\Prime\Response\ResponseManagerInterface;
use Flasher\Prime\Storage\StorageManagerInterface;

final class Flasher implements FlasherInterface
{
    private ResponseManagerInterface $responseManager;

    private ?StorageManagerInterface $storageManager = null;

    /**
     * @var array<string, callable|NotificationFactoryInterface>
     */
    private array $factories = [];

    public function __construct(
        private readonly string $default = 'flasher',
        ResponseManagerInterface $responseManager = null,
        StorageManagerInterface $storageManager = null,
    ) {
        $this->storageManager = $storageManager;
        $this->responseManager = $responseManager ?: new ResponseManager(storageManager: $storageManager);
    }

    public function use(?string $alias): NotificationFactoryInterface
    {
        $alias = trim($alias ?: $this->default);

        if (empty($alias)) {
            throw new \InvalidArgumentException('Unable to resolve empty factory.');
        }

        if (!isset($this->factories[$alias])) {
            $this->addFactory($alias, new NotificationFactory($this->storageManager, $alias));
        }

        $factory = $this->factories[$alias];

        return \is_callable($factory) ? $factory() : $factory;
    }

    public function render(string $presenter = 'html', array $criteria = [], array $context = []): mixed
    {
        return $this->responseManager->render($criteria, $presenter, $context);
    }

    public function addFactory(string $alias, callable|NotificationFactoryInterface $factory): void
    {
        $this->factories[$alias] = $factory;
    }

    /**
     * Dynamically call the default factory instance.
     *
     * @param mixed[] $parameters
     */
    public function __call(string $method, array $parameters): mixed
    {
        /** @var callable $callback */
        $callback = [$this->use(null), $method];

        return $callback(...$parameters);
    }
}
