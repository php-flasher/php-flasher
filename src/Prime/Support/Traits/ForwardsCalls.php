<?php

declare(strict_types=1);

/**
 * ForwardsCalls Trait.
 *
 * This file contains the ForwardsCalls trait, which is used to forward method calls
 * to another object. This trait is originally part of the Laravel framework.
 *
 * @see https://github.com/laravel/framework/blob/10.x/src/Illuminate/Support/Traits/ForwardsCalls.php
 *
 * Laravel is an open-source PHP framework, which this trait is a part of. The original
 * source code has been modified to suit the needs of the PHP-Flasher project.
 *
 * @copyright Laravel
 * @license MIT License
 *
 * @see https://laravel.com/docs/10.x/
 */

namespace Flasher\Prime\Support\Traits;

trait ForwardsCalls
{
    /**
     * Forward a method call to the given object.
     *
     * @param mixed[] $parameters
     *
     * @throws \BadMethodCallException
     */
    protected function forwardCallTo(object $object, string $method, array $parameters): mixed
    {
        try {
            return $object->{$method}(...$parameters);
        } catch (\Error|\BadMethodCallException $e) {
            $pattern = '~^Call to undefined method (?P<class>[^:]+)::(?P<method>[^\(]+)\(\)$~';

            if (!preg_match($pattern, $e->getMessage(), $matches)) {
                throw $e;
            }

            if ($matches['class'] !== $object::class || $matches['method'] !== $method) {
                throw $e;
            }

            static::throwBadMethodCallException($method);
        }
    }

    /**
     * Forward a method call to the given object, returning $this if the forwarded call returned itself.
     *
     * @param mixed[] $parameters
     *
     * @throws \BadMethodCallException
     */
    protected function forwardDecoratedCallTo(object $object, string $method, array $parameters): mixed
    {
        $result = $this->forwardCallTo($object, $method, $parameters);

        return $result === $object ? $this : $result;
    }

    /**
     * Throw a bad method call exception for the given method.
     *
     * @throws \BadMethodCallException
     */
    protected static function throwBadMethodCallException(string $method): never
    {
        throw new \BadMethodCallException(\sprintf('Call to undefined method %s::%s()', static::class, $method));
    }
}
