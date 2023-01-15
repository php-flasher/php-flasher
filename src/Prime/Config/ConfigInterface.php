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
 *   options: array<string, string>,
 *   themes: array<string, array{
 *      view: string,
 *      styles: string[],
 *      scripts: string[],
 *      options: array<string, mixed>,
 *   }>,
 *   auto_render: bool,
 *   auto_translate: bool,
 *   filter_criteria: array<string, mixed>,
 *   flash_bag: array{
 *      enabled: bool,
 *      mapping: array<string, string[]>,
 *   },
 *   presets: array<string, array{
 *      type: string,
 *      title: string,
 *      message: string,
 *      options: array<string, mixed>,
 *   }>,
 * }
 */
interface ConfigInterface
{
    /**
     * Returns an attribute.
     *
     * @param string $key
     * @param mixed  $default the default value if not found
     *
     * @return mixed
     */
    public function get($key, $default = null);
}
