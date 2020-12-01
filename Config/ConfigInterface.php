<?php

namespace Flasher\Prime\Config;

interface ConfigInterface
{
    /**
     * Returns an attribute.
     *
     * @param string $key
     * @param mixed  $default The default value if not found.
     *
     * @return mixed
     */
    public function get($key, $default = null);
}
