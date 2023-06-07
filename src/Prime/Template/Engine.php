<?php

namespace Flasher\Prime\Template;

final class Engine implements EngineInterface
{
    public function render($name, array $context = [])
    {
        ob_start();

        extract($context, \EXTR_SKIP);

        if (!file_exists($name)) {
            $name = __DIR__.'/views/'.$name;

            if (!file_exists($name)) {
                throw new \Exception(sprintf('Cannot find template "%s"', $name));
            }
        }

        include $name;

        $output = ob_get_clean();
        if (false === $output) {
            return '';
        }

        return ltrim($output);
    }
}
