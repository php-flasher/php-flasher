<?php

declare(strict_types=1);

namespace Flasher\Prime\Stamp;

final readonly class PresenterStamp implements StampInterface
{
    public function __construct(private string $pattern)
    {
        if (false === @preg_match($pattern, '')) {
            throw new \InvalidArgumentException(\sprintf("The provided regex pattern '%s' is invalid for the presenter stamp. Please ensure it is a valid regex expression.", $pattern));
        }
    }

    public function getPattern(): string
    {
        return $this->pattern;
    }
}
