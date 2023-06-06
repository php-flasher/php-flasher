<?php

namespace Flasher\Prime\Template;

final class PHPTemplateEngine implements TemplateEngineInterface
{
    public function render($name, array $context = [])
    {
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
