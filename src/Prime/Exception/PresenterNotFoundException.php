<?php

declare(strict_types=1);

namespace Flasher\Prime\Exception;

final class PresenterNotFoundException extends \Exception
{
    /**
     * @param string[] $availablePresenters
     */
    public static function create(string $alias, array $availablePresenters = []): self
    {
        $message = sprintf('Presenter "%s" not found, did you forget to register it?', $alias);

        if ([] !== $availablePresenters) {
            $message .= sprintf(' Available presenters: [%s]', implode(', ', $availablePresenters));
        }

        return new self($message);
    }
}
