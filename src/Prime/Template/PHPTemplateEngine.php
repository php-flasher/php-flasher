<?php

declare(strict_types=1);

namespace Flasher\Prime\Template;

/**
 * PHPTemplateEngine - Simple PHP-based template rendering engine.
 *
 * This implementation provides a straightforward template rendering mechanism using
 * native PHP as the template language. It works by including PHP files and extracting
 * context variables into the template's scope.
 *
 * Design patterns:
 * - Strategy: Implements a specific template rendering strategy
 * - Output Capture: Uses output buffering to capture rendered content
 *
 * Security considerations:
 * - Context variables are extracted with EXTR_SKIP flag to prevent variable overwriting
 * - Template files must exist and be readable
 */
final class PHPTemplateEngine implements TemplateEngineInterface
{
    /**
     * {@inheritdoc}
     *
     * This implementation:
     * 1. Verifies the template file exists and is readable
     * 2. Starts output buffering
     * 3. Extracts context variables into the current scope
     * 4. Includes the template file
     * 5. Captures and returns the output
     *
     * @throws \InvalidArgumentException If the template file doesn't exist or isn't readable
     */
    public function render(string $name, array $context = []): string
    {
        if (!file_exists($name) || !is_readable($name)) {
            throw new \InvalidArgumentException(\sprintf('Template file "%s" does not exist or is not readable.', $name));
        }

        ob_start();

        extract($context, \EXTR_SKIP);

        include $name;

        $output = ob_get_clean();

        if (false === $output) {
            return '';
        }

        return ltrim($output);
    }
}
