<?php

declare(strict_types=1);

namespace Flasher\Symfony\Storage;

/**
 * FallbackSession acts as a stand-in when the regular session is not available.
 */
final class FallbackSession
{
    /** @var array<string, mixed> */
    private static array $storage = [];

    /**
     * Retrieves a value from the fallback session storage.
     *
     * @param string $name    the name of the value
     * @param mixed  $default the default value to return if the name is not found
     *
     * @return mixed the value from storage or default
     */
    public function get(string $name, mixed $default = null): mixed
    {
        return \array_key_exists($name, self::$storage) ? self::$storage[$name] : $default;
    }

    /**
     * Stores a value in the fallback session storage.
     *
     * @param string $name  the name of the value to store
     * @param mixed  $value the value to store
     */
    public function set(string $name, mixed $value): void
    {
        self::$storage[$name] = $value;
    }
}
