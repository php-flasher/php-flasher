<?php

declare(strict_types=1);

namespace Flasher\Prime\Exception;

final class CriteriaNotRegisteredException extends \Exception
{
    /**
     * @param string[] $availableCriteria
     */
    public static function create(string $alias, array $availableCriteria = []): self
    {
        $message = sprintf('Criteria "%s" is not found, did you forget to register it?', $alias);

        if ([] !== $availableCriteria) {
            $message .= sprintf(' Available criteria: [%s]', implode(', ', $availableCriteria));
        }

        return new self($message);
    }
}
