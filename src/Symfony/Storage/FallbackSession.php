<?php

declare(strict_types=1);

namespace Flasher\Symfony\Storage;

/**
 * FallbackSession - In-memory session storage fallback.
 *
 * This class provides a simple in-memory storage mechanism that can be used
 * when the regular Symfony session is not available. It stores values in a
 * static array, making them available for the duration of the request.
 *
 * Design patterns:
 * - Null Object Pattern: Provides a non-failing alternative to a missing session
 * - In-Memory Repository: Stores data in memory as a simple alternative to persistence
 * - Singleton-like Pattern: Uses a static storage array shared across instances
 */
final class FallbackSession implements FallbackSessionInterface
{
    /**
     * In-memory storage for session data.
     *
     * @var array<string, mixed>
     */
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
