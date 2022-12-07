<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

namespace Flasher\Prime;

use Flasher\Prime\Factory\NotificationFactoryInterface;
use Flasher\Prime\Notification\NotificationBuilderInterface;

/**
 * @mixin NotificationBuilderInterface
 */
interface FlasherInterface
{
    /**
     * Get a driver instance.
     *
     * @param string|null $alias
     *
     * @return NotificationFactoryInterface
     *
     * @throws \InvalidArgumentException
     */
    public function create($alias = null);

    /**
     * Get a driver instance.
     *
     * @param string|null $alias
     *
     * @return NotificationFactoryInterface
     *
     * @throws \InvalidArgumentException
     */
    public function using($alias);

    /**
     * Register a custom driver creator.
     *
     * @param string                                $alias
     * @param callable|NotificationFactoryInterface $factory
     *
     * @return static
     */
    public function addFactory($alias, $factory);

    /**
     * @param array<string, mixed> $criteria
     * @param string               $presenter
     * @param array<string, mixed> $context
     *
     * @return mixed
     *
     * @phpstan-return ($presenter is 'html' ? string : mixed)
     */
    public function render(array $criteria = array(), $presenter = 'html', array $context = array());
}
