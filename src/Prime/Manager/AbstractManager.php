<?php

namespace Flasher\Prime\Manager;

use InvalidArgumentException;
use Flasher\Prime\Config\ConfigInterface;

abstract class AbstractManager
{
    /**
     * The array of created "drivers".
     *
     * @var array<string, object>
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
     * @param string|null $alias
     *
     * @return object
     *
     * @throws \InvalidArgumentException
     */
    public function make($alias = null)
    {
        $alias = $alias ?: $this->getDefaultDriver();

        if (!isset($this->drivers[$alias])) {
            throw new InvalidArgumentException(sprintf('Driver [%s] not supported.', $alias));
        }

        return $this->drivers[$alias];
    }

    /**
     * Register a custom driver creator.
     *
     * @param string $alias
     * @param \Closure|object $driver
     *
     * @return $this
     */
    public function addDriver($alias, $driver)
    {
        $this->drivers[$alias] = $driver;

        return $this;
    }

    /**
     * @return string|null
     */
    protected function getDefaultDriver()
    {
        return null;
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
}
