<?php

declare(strict_types=1);

namespace Flasher\Prime\Stamp;

final class ContextStamp implements StampInterface, PresentableStampInterface
{
    /**
     * @param  array<string, mixed>  $context
     */
    public function __construct(private readonly array $context)
    {
    }

    /**
     * @return array<string, mixed>
     */
    public function getContext(): array
    {
        return $this->context;
    }

    /**
     * @return array{context: array<string, mixed>}
     */
    public function toArray(): array
    {
        return ['context' => $this->context];
    }
}
