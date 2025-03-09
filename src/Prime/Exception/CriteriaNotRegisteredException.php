<?php

declare(strict_types=1);

namespace Flasher\Prime\Exception;

/**
 * CriteriaNotRegisteredException - Thrown when an unregistered filter criterion is requested.
 *
 * This exception is thrown when attempting to use a filter criterion that hasn't been
 * registered with the FilterFactory. It provides a clear error message that includes
 * the requested criterion name and available criteria for debugging purposes.
 *
 * Design pattern: Domain-specific exception - Provides contextual information about the error.
 */
final class CriteriaNotRegisteredException extends \Exception
{
    /**
     * Creates a new CriteriaNotRegisteredException with a descriptive message.
     *
     * @param string   $alias             The name of the criterion that was requested
     * @param string[] $availableCriteria The list of registered criteria names
     *
     * @return self The exception instance
     */
    public static function create(string $alias, array $availableCriteria = []): self
    {
        $message = \sprintf('Criteria "%s" is not found, did you forget to register it?', $alias);

        if ([] !== $availableCriteria) {
            $message .= \sprintf(' Available criteria: [%s]', implode(', ', $availableCriteria));
        }

        return new self($message);
    }
}
