<?php

declare(strict_types=1);

namespace Flasher\Tests\Prime;

class TestCase extends \PHPUnit\Framework\TestCase
{
    /**
     * @param  class-string<\Throwable>  $exceptionName
     * @param  string  $exceptionMessage
     * @param  int  $exceptionCode
     */
    public function setExpectedException($exceptionName, $exceptionMessage = '', $exceptionCode = null): void
    {
        if (method_exists($this, 'expectException')) {
            $this->expectException($exceptionName);
            $this->expectExceptionMessage($exceptionMessage);
        } else {
            // @phpstan-ignore-line
        }
    }

    /**
     * Call a protected or private method of a class using reflection.
     *
     * @param  object|string  $object     instantiated object or FQCN that we will run method
     * @param  string  $methodName method name to call
     * @param  array|mixed  $parameters array of parameters to pass into method
     * @return mixed method return
     *
     * @throws \ReflectionException
     */
    protected function invokeMethod($object, $methodName, $parameters = [])
    {
        $class = \is_string($object) ? $object : $object::class;

        $reflection = new \ReflectionClass($class);

        $method = $reflection->getMethod($methodName);
        $method->setAccessible(true);

        $object = \is_string($object) ? null : $object;
        $parameters = \is_array($parameters) ? $parameters : \array_slice(\func_get_args(), 2);

        return $method->invokeArgs($object, $parameters);
    }

    /**
     * Get the value of a protected or private property of a class using reflection.
     *
     * @param  object|string  $object       instantiated object or FQCN that we will access property from
     * @param  string  $propertyName name of property to access
     * @return mixed property value
     *
     * @throws \ReflectionException
     */
    protected function getProperty($object, $propertyName)
    {
        $class = \is_string($object) ? $object : $object::class;

        $reflection = new \ReflectionClass($class);

        $property = $reflection->getProperty($propertyName);
        $property->setAccessible(true);

        $object = \is_string($object) ? null : $object;

        return $property->getValue($object);
    }

    /**
     * Set the value of a protected or private property of a class using reflection.
     *
     * @param  object|string  $object       instantiated object or FQCN that we will run method
     * @param  string  $propertyName name of property to set
     * @param  mixed  $value        value to set the property to
     * @return void
     *
     * @throws \ReflectionException
     */
    protected function setProperty($object, $propertyName, mixed $value)
    {
        $class = \is_string($object) ? $object : $object::class;

        $reflection = new \ReflectionClass($class);

        $property = $reflection->getProperty($propertyName);
        $property->setAccessible(true);

        $object = \is_string($object) ? null : $object;
        $property->setValue($object, $value);
    }
}
