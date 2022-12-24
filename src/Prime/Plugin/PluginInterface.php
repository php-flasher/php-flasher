<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

namespace Flasher\Prime\Plugin;

use Flasher\Prime\Factory\NotificationFactoryInterface;

interface PluginInterface
{
    /**
     * @return string
     */
    public function getAlias();

    /**
     * @return string
     */
    public function getName();

    /**
     * @return string
     */
    public function getServiceID();

    /**
     * @return class-string<NotificationFactoryInterface>
     */
    public function getFactory();

    /**
     * @return string[]|array{cdn: string[], local: string[]}
     */
    public function getScripts();

    /**
     * @return string[]|array{cdn: string[], local: string[]}
     */
    public function getStyles();

    /**
     * @return array<string, mixed>
     */
    public function getOptions();

    /**
     * @return string
     */
    public function getAssetsDir();

    /**
     * @return string
     */
    public function getResourcesDir();

    /**
     * @param array<string, mixed> $options
     *
     * @return array<string, mixed>
     */
    public function processConfiguration(array $options = array());
}
