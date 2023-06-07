<?php

declare(strict_types=1);

namespace Flasher\Symfony\Storage;

final class FallbackSession
{
    private static array $storage = [];

    /**
     * @param  string  $name
     */
    public function get($name, $default = null)
    {
        return \array_key_exists($name, self::$storage)
            ? self::$storage[$name]
            : $default;
    }

    /**
     * @param  string  $name
     */
    public function set($name, $value): void
    {
        self::$storage[$name] = $value;
    }
}
