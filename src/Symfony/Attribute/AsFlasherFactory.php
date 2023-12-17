<?php

declare(strict_types=1);

namespace Flasher\Symfony\Attribute;

#[\Attribute(\Attribute::TARGET_CLASS)]
class AsFlasherFactory
{
    public function __construct(public readonly string $alias)
    {
    }
}
