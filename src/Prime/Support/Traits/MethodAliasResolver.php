<?php

declare(strict_types=1);

namespace Flasher\Prime\Support\Traits;

trait MethodAliasResolver
{
    /**
     * @var array<string, string>
     */
    protected array $methodAliases = [];

    /**
     * @return array<string, string>
     */
    protected function getMethodAliases(): array
    {
        return $this->methodAliases;
    }

    protected function getMethodAlias(string $method): string
    {
        if (! $this->hasMethodAlias($method)) {
            throw new \BadMethodCallException(sprintf('Method %s::%s does not exist.', static::class, $method));
        }

        return $this->methodAliases[$method];
    }

    protected function hasMethodAlias(string $method): bool
    {
        return array_key_exists($method, $this->methodAliases);
    }

    protected function callMethodAlias(string $method, array $parameters): mixed
    {
        $alias = $this->getMethodAlias($method);

        if (! method_exists($this, $alias)) {
            throw new \BadMethodCallException(sprintf('Method %s::%s does not exist.', static::class, $alias));
        }

        return $this->$alias(...$parameters);
    }
}
