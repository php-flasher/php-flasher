<?php

declare(strict_types=1);

namespace Flasher\Prime\Stamp;

final class HandlerStamp implements StampInterface, PresentableStampInterface
{
    public function __construct(private readonly string $handler)
    {
    }

    public function getHandler(): string
    {
        return $this->handler;
    }

    /**
     * @return array{handler: string}
     */
    public function toArray(): array
    {
        return ['handler' => $this->handler];
    }
}
