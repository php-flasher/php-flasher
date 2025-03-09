<?php

declare(strict_types=1);

namespace Flasher\Laravel\Template;

use Flasher\Prime\Template\TemplateEngineInterface;
use Illuminate\View\Factory;

/**
 * BladeTemplateEngine - Laravel Blade adapter for PHPFlasher templates.
 *
 * This class provides an implementation of PHPFlasher's template engine interface
 * using Laravel's Blade templating system. It allows PHPFlasher to render templates
 * using all of Blade's features.
 *
 * Design patterns:
 * - Adapter: Adapts Laravel's Blade engine to PHPFlasher's template interface
 * - Bridge: Connects PHPFlasher's templating needs with Laravel's templating system
 */
final readonly class BladeTemplateEngine implements TemplateEngineInterface
{
    /**
     * Creates a new BladeTemplateEngine instance.
     *
     * @param Factory $blade Laravel's view factory
     */
    public function __construct(private Factory $blade)
    {
    }

    /**
     * {@inheritdoc}
     *
     * Renders a template using Laravel's Blade engine.
     *
     * @param string               $name    The template name or path
     * @param array<string, mixed> $context The template variables
     *
     * @return string The rendered template
     */
    public function render(string $name, array $context = []): string
    {
        return $this->blade->make($name, $context)->render();
    }
}
