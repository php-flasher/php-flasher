<?php

declare(strict_types=1);

namespace Flasher\Laravel\Template;

use Flasher\Prime\Template\TemplateEngineInterface;
use Illuminate\View\Factory;

final readonly class BladeTemplateEngine implements TemplateEngineInterface
{
    public function __construct(private Factory $blade)
    {
    }

    public function render(string $name, array $context = []): string
    {
        return $this->blade->make($name, $context)->render();
    }
}
