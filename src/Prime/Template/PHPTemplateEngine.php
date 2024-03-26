<?php

declare(strict_types=1);

namespace Flasher\Prime\Template;

final class PHPTemplateEngine implements TemplateEngineInterface
{
    public function render(string $name, array $context = []): string
    {
        if (!file_exists($name) || !is_readable($name)) {
            throw new \InvalidArgumentException(sprintf('Template file "%s" does not exist or is not readable.', $name));
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
