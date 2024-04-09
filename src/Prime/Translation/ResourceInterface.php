<?php

declare(strict_types=1);

namespace Flasher\Prime\Translation;

interface ResourceInterface
{
    public function getResourceType(): string;

    public function getResourceName(): string;
}
