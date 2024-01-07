<?php

declare(strict_types=1);

namespace Flasher\Prime\Support\Traits;

/**
 * Trait MethodAliasResolver.
 *
 * Provides functionality to resolve method aliases. This trait allows defining
 * aliases for methods, enabling the calling of one method while internally
 * redirecting to another method within the same class.
 */
trait MethodAliasResolver
{
    /**
     * Map of method aliases to their corresponding real method names.
     *
     * @var array<string, string>
     */
    protected array $methodAliases = [];

    /**
     * Retrieves all method aliases.
     *
     * @return array<string, string>
     */
    protected function getMethodAliases(): array
    {
        return $this->methodAliases;
    }

    /**
     * Retrieves the real method name for a given alias.
     */
    protected function resolveMethodAlias(string $method): string
    {
        if (!$this->hasMethodAlias($method)) {
            throw new \BadMethodCallException(sprintf('Method %s::%s does not exist.', static::class, $method));
        }

        return $this->methodAliases[$method];
    }

    /**
     * Checks if a method alias exists.
     */
    protected function hasMethodAlias(string $method): bool
    {
        return \array_key_exists($method, $this->methodAliases);
    }

    /**
     * Calls the real method for a given alias with the provided parameters.
     *
     * @param array<string, mixed> $parameters
     */
    protected function callMethodAlias(string $method, array $parameters): mixed
    {
        $alias = $this->resolveMethodAlias($method);

        if (!method_exists($this, $alias)) {
            throw new \BadMethodCallException(sprintf('Method %s::%s does not exist.', static::class, $alias));
        }

        return $this->$alias(...$parameters);
    }
}
