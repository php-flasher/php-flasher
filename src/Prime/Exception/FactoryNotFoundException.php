<?php

declare(strict_types=1);

namespace Flasher\Prime\Exception;

final class FactoryNotFoundException extends \Exception
{
    /**
     * @param string[] $availableFactories
     */
    public function __construct(string $alias, array $availableFactories = [])
    {
        $message = sprintf('Factory "%s" not found, did you forget to register it?', $alias);
        if ([] !== $availableFactories) {
            $message .= sprintf(' Available factories: %s', implode(', ', $availableFactories));
        }

        parent::__construct($message);
    }
}
