<?php

namespace Flasher\Symfony\Storage;

class FallbackSession
{
    private static $storage = array();

    /**
     * @param string $name
     * @param mixed  $default
     *
     * @return mixed
     */
    public function get($name, $default = null)
    {
        return array_key_exists($name, self::$storage)
            ? self::$storage[$name]
            : $default;
    }

    /**
     * @param string $name
     * @param mixed  $value
     *
     * @return void
     */
    public function set($name, $value)
    {
        self::$storage[$name] = $value;
    }
}
