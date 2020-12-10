<?php

namespace Flasher\Prime;

use Flasher\Prime\Config\ConfigInterface;
use Flasher\Prime\Factory\FactoryInterface;

final class Flasher implements FlasherInterface
{
    /**
     * The array of created notification "factories".
     *
     * @var array<string, object>
     */
    private $factories = array();

    /**
     * @var ConfigInterface
     */
    private $config;

    /**
     * @param ConfigInterface $config
     */
    public function __construct(ConfigInterface $config)
    {
        $this->config = $config;
    }

    /**
     * @inheritDoc
     */
    public function create($alias = null)
    {
        $alias = $alias ?: $this->getDefaultFactory();

        if (!isset($this->factories[$alias])) {
            throw new \InvalidArgumentException(sprintf('Factory [%s] not supported.', $alias));
        }

        return $this->factories[$alias];
    }

    /**
     * @inheritDoc
     */
    public function addFactory($alias, FactoryInterface $factory)
    {
        $this->factories[$alias] = $factory;

        return $this;
    }

    /**
     * @return string|null
     */
    private function getDefaultFactory()
    {
        return $this->config->get('default');
    }

    /**
     * Dynamically call the default factory instance.
     *
     * @param string $method
     * @param array  $parameters
     *
     * @return mixed
     */
    public function __call($method, array $parameters)
    {
        return call_user_func_array(array($this->create(), $method), $parameters);
    }
}
