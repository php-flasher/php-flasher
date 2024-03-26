<?php

declare(strict_types=1);

namespace Flasher\Prime\Stamp;

final readonly class PluginStamp implements PresentableStampInterface, StampInterface
{
    public function __construct(private string $plugin)
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
