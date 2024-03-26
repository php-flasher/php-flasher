<?php

declare(strict_types=1);

/**
 * Macroable Trait.
 *
 * The Macroable trait provides a simple implementation of the "macro" functionality
 * that allows classes to dynamically add methods at runtime. This trait is adapted
 * from a similar implementation in the Laravel framework.
 *
 * @see https://github.com/laravel/framework/blob/10.x/src/Illuminate/Macroable/Traits/Macroable.php
 *
 * Laravel is an open-source PHP framework, which includes the original version of
 * this trait. The source code in this file has been modified to suit the specific
 * needs of the PHP-Flasher project.
 *
 * @copyright Laravel
 * @license MIT License
 *
 * @see https://laravel.com/docs/10.x/
 */

namespace Flasher\Prime\Support\Traits;

trait Macroable
{
    /**
     * The registered string macros.
     *
     * @var array<string, callable|object>
     */
    protected static array $macros = [];

    /**
     * Register a custom macro.
     */
    public static function macro(string $name, object|callable $macro): void
    {
        static::$macros[$name] = $macro;
    }

    /**
     * Mix another object into the class.
     *
     * @throws \ReflectionException
     * @throws \InvalidArgumentException
     */
    public static function mixin(object $mixin, bool $replace = true): void
    {
        $methods = (new \ReflectionClass($mixin))->getMethods(
            \ReflectionMethod::IS_PUBLIC | \ReflectionMethod::IS_PROTECTED
        );

        foreach ($methods as $method) {
            $macro = $method->invoke($mixin);

            if (!\is_callable($macro) && !\is_object($macro)) {
                throw new \InvalidArgumentException(sprintf('Expect the result of method %s::%s from the mixin object to be be a callable or an object, got "%s".', $mixin::class, $method->name, get_debug_type($macro)));
            }

            if ($replace || !static::hasMacro($method->name)) {
                static::macro($method->name, $macro);
            }
        }
    }

    /**
     * Checks if macro is registered.
     */
    public static function hasMacro(string $name): bool
    {
        return isset(static::$macros[$name]);
    }

    /**
     * Dynamically handle calls to the class.
     *
     * @param mixed[] $parameters
     *
     * @throws \BadMethodCallException
     */
    public static function __callStatic(string $method, array $parameters): mixed
    {
        if (!static::hasMacro($method)) {
            throw new \BadMethodCallException(sprintf('Method %s::%s does not exist.', static::class, $method));
        }

        $macro = static::$macros[$method];

        if ($macro instanceof \Closure) {
            $macro = $macro->bindTo(null, static::class);
        }

        if (!\is_callable($macro)) {
            throw new \BadMethodCallException(sprintf('Macro %s is not callable.', $method));
        }

        return $macro(...$parameters);
    }

    /**
     * Dynamically handle calls to the class.
     *
     * @param mixed[] $parameters
     *
     * @throws \BadMethodCallException
     */
    public function __call(string $method, array $parameters): mixed
    {
        if (!static::hasMacro($method)) {
            throw new \BadMethodCallException(sprintf('Method %s::%s does not exist.', static::class, $method));
        }

        $macro = static::$macros[$method];

        if ($macro instanceof \Closure) {
            $macro = $macro->bindTo($this, static::class);
        }

        if (!\is_callable($macro)) {
            throw new \BadMethodCallException(sprintf('Macro %s is not callable.', $method));
        }

        return $macro(...$parameters);
    }
}
