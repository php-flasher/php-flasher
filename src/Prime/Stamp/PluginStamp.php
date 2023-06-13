<?php

declare(strict_types=1);

namespace Flasher\Prime\Stamp;

final class PluginStamp implements StampInterface, PresentableStampInterface
{
    public function __construct(private readonly string $handler)
    {
    }

    public function getPlugin(): string
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
