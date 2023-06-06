<?php

namespace Flasher\Symfony\Storage;

class FallbackSession
{
    private static $storage = [];

    /**
     * @param string $name
     */
    public function get($name, $default = null)
    {
        return \array_key_exists($name, self::$storage)
            ? self::$storage[$name]
            : $default;
    }

    /**
     * @param string $name
     *
     * @return void
     */
    public function set($name, $value)
    {
        self::$storage[$name] = $value;
    }
}
