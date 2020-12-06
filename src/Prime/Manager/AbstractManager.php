<?php

namespace Flasher\Prime\Manager;

use InvalidArgumentException;
use Flasher\Prime\Config\ConfigInterface;

abstract class AbstractManager
{
    /**
     * The array of created "drivers".
     *
     * @var array<object>
     */
    protected $drivers = array();

    /**
     * @var ConfigInterface
     */
    protected $config;

    /**
     * @param ConfigInterface $config
     */
    public function __construct(ConfigInterface $config)
    {
        $this->config = $config;
    }

    /**
     * Get a driver instance.
     *
     * @param string|null $name
     * @param array       $context
     *
     * @return object
     *
     * @throws \InvalidArgumentException
     */
    public function make($name = null, array $context = array())
    {
        $name = $name ?: $this->getDefaultDriver();

        if (!is_string($name)) {
            $context = is_array($name) ? $name : array($name);
            $name    = null;
        }

        foreach ($this->drivers as $driver) {
            if ($driver->supports($name, $context)) {
                return $driver;
            }
        }

        throw new InvalidArgumentException(sprintf('Driver [%s] not supported.', $name));
    }

    /**
     * Register a custom driver creator.
     *
     * @param \Closure|object $driver
     *
     * @return $this
     */
    public function addDriver($driver)
    {
        $this->drivers[] = $driver;

        return $this;
    }

    /**
     * @return ConfigInterface
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * Dynamically call the default driver instance.
     *
     * @param string $method
     * @param array  $parameters
     *
     * @return mixed
     */
    public function __call($method, array $parameters)
    {
        return call_user_func_array(array($this->make(), $method), $parameters);
    }

    /**
     * @return string|null
     */
    protected function getDefaultDriver()
    {
        return null;
    }
}
