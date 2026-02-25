<?php

declare(strict_types=1);

namespace Flasher\Laravel\Storage;

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

    public static function reset(): void
    {
        self::$storage = [];
    }
}
