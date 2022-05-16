<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

namespace Flasher\Prime\Config;

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
