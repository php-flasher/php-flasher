<?php

declare(strict_types=1);

namespace Flasher\Livewire;

use Flasher\Prime\Stamp\PresentableStampInterface;
use Flasher\Prime\Stamp\StampInterface;

class LivewireStamp implements StampInterface, PresentableStampInterface
{
    private $context;

    public function __construct(array $context = [])
    {
        $this->context = $context;
    }

    public function getContext(): array
    {
        return $this->context;
    }

    public function toArray()
    {
        return [
            'livewire_context' => $this->getContext(),
        ];
    }
}
