<?php

declare(strict_types=1);

namespace Flasher\Symfony\Component;

final class FlasherComponent
{
    /** @var array<string, mixed> */
    public array $criteria = [];

    public string $presenter = 'html';

    /** @var array<string, mixed> */
    public array $context = [];
}
