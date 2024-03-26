<?php

declare(strict_types=1);

namespace Flasher\Symfony\Storage;

/**
 * FallbackSession acts as a stand-in when the regular session is not available.
 */
final class FallbackSession implements FallbackSessionInterface
{
    /** @var array<string, mixed> */
    private static array $storage = [];

    public function get(string $name, mixed $default = null): mixed
    {
        return \array_key_exists($name, self::$storage) ? self::$storage[$name] : $default;
    }

    public function set(string $name, mixed $value): void
    {
        self::$storage[$name] = $value;
    }
}
