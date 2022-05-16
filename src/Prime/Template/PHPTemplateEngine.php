<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

namespace Flasher\Prime\Template;

final class PHPTemplateEngine implements TemplateEngineInterface
{
    /**
     * {@inheritdoc}
     */
    public function render($name, array $context = array())
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
