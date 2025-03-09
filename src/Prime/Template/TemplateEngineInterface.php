<?php

declare(strict_types=1);

namespace Flasher\Prime\Template;

/**
 * TemplateEngineInterface - Contract for template rendering engines.
 *
 * This interface defines the essential operation for template rendering engines
 * in PHPFlasher. Template engines are responsible for transforming template files
 * into HTML content, particularly for notifications that require custom rendering.
 *
 * Design patterns:
 * - Strategy: Defines a family of template rendering algorithms that can be used interchangeably
 * - Adapter: Provides a common interface for different template engine implementations
 */
interface TemplateEngineInterface
{
    /**
     * Renders a template with the given context variables.
     *
     * This method transforms a template file or string into rendered HTML by
     * substituting variables from the context array.
     *
     * @param string               $name    The template name/path to render
     * @param array<string, mixed> $context Variables to pass to the template
     *
     * @return string The rendered template as a string
     *
     * @throws \InvalidArgumentException If the template cannot be found or parsed
     */
    public function render(string $name, array $context = []): string;
}
