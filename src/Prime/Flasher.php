<?php

namespace Flasher\Prime;

use Flasher\Prime\Config\ConfigInterface;
use Flasher\Prime\Factory\NotificationFactoryInterface;
use Flasher\Prime\Response\ResponseManagerInterface;

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

    /** @var ResponseManagerInterface */
    private $responseManager;

    public function __construct(ConfigInterface $config, ResponseManagerInterface $responseManager)
    {
        $this->config = $config;
        $this->responseManager = $responseManager;
    }

    /**
     * Dynamically call the default factory instance.
     *
     * @param string $method
     *
     * @return mixed
     */
    public function __call($method, array $parameters)
    {
        return call_user_func_array(array($this->create(), $method), $parameters);
    }

    public function create($alias = null)
    {
        $alias = $alias ?: $this->getDefaultFactory();

        if (!isset($this->factories[$alias])) {
            throw new \InvalidArgumentException(sprintf('Factory [%s] not supported.', $alias));
        }

        return $this->factories[$alias];
    }

    public function using($alias)
    {
        return $this->create($alias);
    }

    public function addFactory($alias, NotificationFactoryInterface $factory)
    {
        $this->factories[$alias] = $factory;

        return $this;
    }

    public function render(array $criteria = array(), $presenter = 'html', array $context = array())
    {
        return $this->responseManager->render($criteria, $presenter, $context);
    }

    /**
     * @return string|null
     */
    private function getDefaultFactory()
    {
        return $this->config->get('default');
    }
}
