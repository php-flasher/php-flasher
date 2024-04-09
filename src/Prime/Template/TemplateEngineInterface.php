<?php

declare(strict_types=1);

namespace Flasher\Prime\Template;

interface TemplateEngineInterface
{
    /**
     * @param array<string, mixed> $context
     */
    public function render(string $name, array $context = []): string;
}
