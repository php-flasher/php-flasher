<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

namespace Flasher\Prime;

use Flasher\Prime\Factory\NotificationFactory;
use Flasher\Prime\Factory\NotificationFactoryInterface;
use Flasher\Prime\Notification\NotificationBuilderInterface;
use Flasher\Prime\Response\ResponseManager;
use Flasher\Prime\Response\ResponseManagerInterface;
use Flasher\Prime\Storage\StorageManagerInterface;

/**
 * @mixin NotificationBuilderInterface
 */
final class Flasher implements FlasherInterface
{
    /**
     * @var string|null
     */
    private $defaultHandler;

    /**
     * @var ResponseManagerInterface
     */
    private $responseManager;

    /**
     * @var StorageManagerInterface|null
     */
    private $storageManager;

    /**
     * @var array<string, callable|NotificationFactoryInterface>
     */
    private $factories = array();

    /**
     * @param string $defaultHandler
     */
    public function __construct($defaultHandler, ResponseManagerInterface $responseManager = null, StorageManagerInterface $storageManager = null)
    {
        $this->defaultHandler = $defaultHandler ?: 'flasher';
        $this->responseManager = $responseManager ?: new ResponseManager();
        $this->storageManager = $storageManager;
    }

    /**
     * Dynamically call the default factory instance.
     *
     * @param string  $method
     * @param mixed[] $parameters
     *
     * @return mixed
     */
    public function __call($method, array $parameters)
    {
        /** @var callable $callback */
        $callback = array($this->create(), $method);

        return \call_user_func_array($callback, $parameters);
    }

    /**
     * {@inheritdoc}
     */
    public function create($alias = null)
    {
        $alias = trim($alias ?: $this->defaultHandler ?: '');

        if (0 === strpos($alias, 'template.')) {
            $alias = 'theme.'.substr($alias, \strlen('template.'));
            @trigger_error('Since php-flasher/flasher v1.0, the "template." prefix is deprecated and will be removed in v2.0. Use "theme." instead.', \E_USER_DEPRECATED);
        }

        if (empty($alias)) {
            throw new \InvalidArgumentException('Unable to resolve empty factory.');
        }

        if (!isset($this->factories[$alias])) {
            $this->addFactory($alias, new NotificationFactory($this->storageManager, $alias));
        }

        $factory = $this->factories[$alias];

        return \is_callable($factory) ? $factory() : $factory;
    }

    /**
     * {@inheritdoc}
     */
    public function using($alias)
    {
        return $this->create($alias);
    }

    /**
     * {@inheritdoc}
     */
    public function render(array $criteria = array(), $presenter = 'html', array $context = array())
    {
        return $this->responseManager->render($criteria, $presenter, $context);
    }

    /**
     * {@inheritdoc}
     */
    public function addFactory($alias, $factory)
    {
        $this->factories[$alias] = $factory;

        return $this;
    }
}
