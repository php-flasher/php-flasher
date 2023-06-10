<?php

declare(strict_types=1);

namespace Flasher\Prime\Exception;

class CriteriaNotRegisteredException extends \Exception
{
    /**
     * @param  string[]  $availableCriterias
     */
    public function __construct(string $alias, array $availableCriterias = [])
    {
        $message = sprintf('Criteria "%s" is not found, did you forget to register it?', $alias);

        if ([] !== $availableCriterias) {
            $message .= sprintf(' Available criteria: %s', implode(', ', $availableCriterias));
        }

        parent::__construct($message);
    }
}
