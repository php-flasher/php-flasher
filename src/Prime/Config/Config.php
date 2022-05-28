<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

namespace Flasher\Prime\Config;

/**
 * @phpstan-type ConfigType array{
 *   default: string,
 *   root_script: string,
 *   themes: array<string, array{
 *      view: string,
 *      styles: string[],
 *      scripts: string[],
 *      options: array<string, mixed>,
 *   }>,
 *   auto_translate: bool,
 *   flash_bag?: array{
 *      enabled: bool,
 *      mapping: array<string, string>,
 *   },
 *   presets: array<string, array{
 *      type: string,
 *      title: string,
 *      message: string,
 *      options: array<string, mixed>,
 *   }>,
 * }
 */
final class Config implements ConfigInterface
{
    /**
     * @phpstan-var ConfigType
     */
    private $config;

    /**
     * @phpstan-param ConfigType $config
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

            $data = $data[$segment]; // @phpstan-ignore-line
        }

        return $data;
    }
}
