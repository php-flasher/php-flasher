<?php

declare(strict_types=1);

namespace Flasher\Tests\Prime\Helper;

/**
 * @template T of object
 *
 * @phpstan-type PropertyType array{name: string, type: string|null, accessible: bool}
 *
 * @mixin T
 */
final class ObjectInvader
{
    /**
     * @phpstan-var T
     */
    public object $obj;

    /**
     * @phpstan-var \ReflectionClass<T>
     */
    public \ReflectionClass $reflected;

    /**
     * @phpstan-param T $obj
     *
     * @throws \ReflectionException
     */
    public function __construct(object $obj)
    {
        $this->obj = $obj;
        $this->reflected = new \ReflectionClass($obj);
    }

    /**
     * @phpstan-param T $obj
     *
     * @phpstan-return self<T>
     *
     * @throws \ReflectionException
     */
    public static function from(object $obj): self
    {
        return new self($obj);
    }

    /**
     * Allows dynamic property access.
     *
     * @param string $name name of the property
     *
     * @throws \ReflectionException
     */
    public function get(string $name): mixed
    {
        $property = $this->reflected->getProperty($name);

        $property->setAccessible(true);

        return $property->getValue($this->obj);
    }

    /**
     * Allows dynamic setting of properties.
     *
     * @param string $name  name of the property
     * @param mixed  $value new value for the property
     *
     * @throws \ReflectionException
     */
    public function set(string $name, mixed $value): void
    {
        $property = $this->reflected->getProperty($name);

        $property->setAccessible(true);

        $property->setValue($this->obj, $value);
    }

    /**
     * Allows dynamic calling of methods.
     *
     * @param string $name   name of the method
     * @param array  $params parameters to pass to the method
     *
     * @throws \ReflectionException
     *
     * @phpstan-ignore-next-line
     */
    public function call(string $name, array $params = []): mixed
    {
        $method = $this->reflected->getMethod($name);

        $method->setAccessible(true);

        return $method->invoke($this->obj, ...$params);
    }
}
