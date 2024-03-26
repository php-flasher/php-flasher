<?php

declare(strict_types=1);

namespace Flasher\Symfony\Attribute;

#[\Attribute(\Attribute::TARGET_CLASS)]
final readonly class AsFlasherPresenter
{
    public function __construct(public string $alias)
    {
    }
}
