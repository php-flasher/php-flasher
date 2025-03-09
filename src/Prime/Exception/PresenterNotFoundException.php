<?php

declare(strict_types=1);

namespace Flasher\Prime\Exception;

/**
 * PresenterNotFoundException - Thrown when an unregistered presenter is requested.
 *
 * This exception is thrown when attempting to use a notification presenter that hasn't been
 * registered with the system. It provides a clear error message that includes the requested
 * presenter name and available presenters for debugging purposes.
 *
 * Design pattern: Domain-specific exception - Provides contextual information about the error.
 */
final class PresenterNotFoundException extends \Exception
{
    /**
     * Creates a new PresenterNotFoundException with a descriptive message.
     *
     * @param string   $alias               The name of the presenter that was requested
     * @param string[] $availablePresenters The list of registered presenter names
     *
     * @return self The exception instance
     */
    public static function create(string $alias, array $availablePresenters = []): self
    {
        $message = \sprintf('Presenter "%s" not found, did you forget to register it?', $alias);

        if ([] !== $availablePresenters) {
            $message .= \sprintf(' Available presenters: [%s]', implode(', ', $availablePresenters));
        }

        return new self($message);
    }
}
