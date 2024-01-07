<?php

declare(strict_types=1);

namespace Flasher\Tests\Prime;

class TestCase extends \PHPUnit\Framework\TestCase
{
    /**
     * @param class-string<\Throwable> $exceptionName
     */
    protected function setExpectedException(string $exceptionName, string $exceptionMessage = ''): void
    {
        $this->expectException($exceptionName);
        $this->expectExceptionMessage($exceptionMessage);
    }

    /**
     * Call a protected or private method of a class using reflection.
     *
     * @param object|string $object     instantiated object or FQCN that we will run method
     * @param string        $methodName method name to call
     * @param array|mixed   $parameters array of parameters to pass into method
     *
     * @return mixed method return
     *
     * @throws \ReflectionException
     */
    protected function invokeMethod(object|string $object, string $methodName, array $parameters = [])
    {
        $reflection = new \ReflectionClass($object);

        $method = $reflection->getMethod($methodName);
        $method->setAccessible(true);

        return $method->invokeArgs(\is_string($object) ? null : $object, $parameters);
    }

    /**
     * Get the value of a protected or private property of a class using reflection.
     *
     * @param object|string $object       instantiated object or FQCN that we will access property from
     * @param string        $propertyName name of property to access
     *
     * @return mixed property value
     */
    protected function getProperty(object|string $object, string $propertyName): mixed
    {
        $reflection = new \ReflectionClass($object);

        $property = $reflection->getProperty($propertyName);
        $property->setAccessible(true);

        // Ensure that an object instance is provided for non-static properties
        if (\is_string($object)) {
            if (!$property->isStatic()) {
                throw new \InvalidArgumentException("An instance of the class is required to access the non-static property '{$propertyName}'.");
            }

            return $property->getValue();
        }

        return $property->getValue($object);
    }

    /**
     * Set the value of a protected or private property of a class using reflection.
     *
     * @param object|string $object       instantiated object or FQCN that we will run method
     * @param string        $propertyName name of property to set
     * @param mixed         $value        value to set the property to
     */
    protected function setProperty(object|string $object, string $propertyName, mixed $value): void
    {
        $reflection = new \ReflectionClass($object);

        $property = $reflection->getProperty($propertyName);
        $property->setAccessible(true);

        $property->setValue(\is_string($object) ? null : $object, $value);
    }
}
