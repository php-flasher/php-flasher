<?php

declare(strict_types=1);

namespace Flasher\Prime\Exception;

/**
 * FactoryNotFoundException - Thrown when an unregistered notification factory is requested.
 *
 * This exception is thrown when attempting to use a notification factory that hasn't been
 * registered with the system. It provides a clear error message that includes the requested
 * factory name and available factories for debugging purposes.
 *
 * Design pattern: Domain-specific exception - Provides contextual information about the error.
 */
final class FactoryNotFoundException extends \Exception
{
    /**
     * Creates a new FactoryNotFoundException with a descriptive message.
     *
     * @param string   $alias              The name of the factory that was requested
     * @param string[] $availableFactories The list of registered factory names
     *
     * @return self The exception instance
     */
    public static function create(string $alias, array $availableFactories = []): self
    {
        $message = \sprintf('Factory "%s" not found, did you forget to register it?', $alias);

        if ([] !== $availableFactories) {
            $message .= \sprintf(' Available factories: [%s]', implode(', ', $availableFactories));
        }

        return new self($message);
    }
}
