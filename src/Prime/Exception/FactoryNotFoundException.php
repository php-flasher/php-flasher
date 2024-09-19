<?php

declare(strict_types=1);

namespace Flasher\Prime\Exception;

final class FactoryNotFoundException extends \Exception
{
    /**
     * @param string[] $availableFactories
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
