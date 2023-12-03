<?php

declare(strict_types=1);

namespace Flasher\Prime\Stamp;

final class PluginStamp implements PresentableStampInterface, StampInterface
{
    public function __construct(private readonly string $plugin)
    {
    }

    public function getPlugin(): string
    {
        return $this->plugin;
    }

    /**
     * @return array{plugin: string}
     */
    public function toArray(): array
    {
        return ['plugin' => $this->plugin];
    }
}
