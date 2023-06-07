<?php

namespace Flasher\Prime\Container;

/**
 * @internal
 */
final class FlasherContainer
{
    /**
     * @var self|null
     */
    private static $instance;

    /**
     * @var ContainerInterface
     */
    private static $container;

    private function __construct(ContainerInterface $container)
    {
        self::$container = $container;
    }

    /**
     * @param string $id
     *
     * @throws \LogicException
     */
    public static function create($id)
    {
        if (null === self::$instance) {
            throw new \LogicException('Container is not initialized yet. Container::init() must be called with a real container.');
        }

        return self::$container->get($id);
    }

    /**
     * @return void
     */
    public static function init(ContainerInterface $container)
    {
        if (null !== self::$instance) {
            return;
        }

        self::$instance = new self($container);
    }
}
