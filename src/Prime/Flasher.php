<?php

declare(strict_types=1);

namespace Flasher\Prime;

use Flasher\Prime\Factory\NotificationFactory;
use Flasher\Prime\Factory\NotificationFactoryInterface;
use Flasher\Prime\Response\ResponseManagerInterface;
use Flasher\Prime\Storage\StorageManagerInterface;
use Flasher\Prime\Support\Traits\ForwardsCalls;

final class Flasher implements FlasherInterface
{
    use ForwardsCalls;

    /**
     * @var array<string, callable|NotificationFactoryInterface>
     */
    private array $factories = [];

    public function __construct(
        private string $default,
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

        if (!isset($this->factories[$alias])) {
            $this->addFactory($alias, new NotificationFactory($this->storageManager));
        }

        $factory = $this->factories[$alias];

        return \is_callable($factory) ? $factory() : $factory;
    }

    public function render(string $presenter = 'html', array $criteria = [], array $context = []): mixed
    {
        return $this->responseManager->render($presenter, $criteria, $context);
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
        return $this->forwardCallTo($this->use(null), $method, $parameters);
    }
}
