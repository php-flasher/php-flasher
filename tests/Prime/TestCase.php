<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

namespace Flasher\Tests\Prime;

class TestCase extends \PHPUnit\Framework\TestCase
{
    /**
     * @param class-string<\Throwable> $exceptionName
     * @param string                   $exceptionMessage
     * @param int                      $exceptionCode
     *
     * @return void
     */
    public function setExpectedException($exceptionName, $exceptionMessage = '', $exceptionCode = null)
    {
        if (method_exists($this, 'expectException')) {
            $this->expectException($exceptionName);
            $this->expectExceptionMessage($exceptionMessage);
        } else {
            parent::setExpectedException($exceptionName, $exceptionMessage, $exceptionCode); // @phpstan-ignore-line
        }
    }

    /**
     * Call protected/private method of a class.
     *
     * @param object      $object     instantiated object that we will run method on
     * @param string      $methodName method name to call
     * @param array|mixed $parameters array of parameters to pass into method
     *
     * @return mixed method return
     *
     * @throws \ReflectionException
     */
    protected function callMethod(&$object, $methodName, $parameters = array())
    {
        $reflection = new \ReflectionClass(\get_class($object));
        $method = $reflection->getMethod($methodName);
        $method->setAccessible(true);

        $parameters = \is_array($parameters) ? $parameters : \array_slice(\func_get_args(), 2);

        return $method->invokeArgs($object, $parameters);
    }
}
