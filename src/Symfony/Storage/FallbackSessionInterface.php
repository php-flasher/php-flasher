<?php

declare(strict_types=1);

namespace Flasher\Symfony\Storage;

/**
 * FallbackSessionInterface - Contract for alternative session storage.
 *
 * This interface defines methods for a fallback storage mechanism when the
 * regular Symfony session is not available. This is particularly useful in
 * stateless contexts or when the session hasn't been started.
 *
 * Design patterns:
 * - Interface Segregation: Defines a minimal interface for session-like storage
 * - Strategy Pattern: Allows different storage implementations to be used
 * - Fallback Strategy: Provides an alternative when primary storage is unavailable
 */
interface FallbackSessionInterface
{
    /**
     * Retrieves a value from the fallback session storage.
     *
     * @param string $name    the name of the value
     * @param mixed  $default the default value to return if the name is not found
     *
     * @return mixed the value from storage or default
     */
    public function get(string $name, mixed $default = null): mixed;

    /**
     * Stores a value in the fallback session storage.
     *
     * @param string $name  the name of the value to store
     * @param mixed  $value the value to store
     */
    public function set(string $name, mixed $value): void;
}
