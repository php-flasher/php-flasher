<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

namespace Flasher\Prime\Config;

/**
 * @phpstan-import-type ConfigType from ConfigInterface
 */
final class Config implements ConfigInterface
{
    /**
     * @phpstan-var array{}|ConfigType
     */
    private $config;

    /**
     * @phpstan-param array{}|ConfigType $config
     */
    public function __construct(array $config = array())
    {
        $this->config = $config;
    }

    /**
     * {@inheritdoc}
     */
    public function get($key, $default = null)
    {
        $data = $this->config;

        foreach (explode('.', $key) as $segment) {
            if (!isset($data[$segment])) { // @phpstan-ignore-line
                return $default;
            }

            $data = $data[$segment];
        }

        return $data;
    }
}
