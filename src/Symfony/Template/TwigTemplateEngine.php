<?php

declare(strict_types=1);

namespace Flasher\Symfony\Template;

use Flasher\Prime\Template\TemplateEngineInterface;
use Twig\Environment;

final readonly class TwigTemplateEngine implements TemplateEngineInterface
{
    public function __construct(private ?Environment $twig = null)
    {
    }

    public function render(string $name, array $context = []): string
    {
        if (null === $this->twig) {
            throw new \LogicException('The TwigBundle is not registered in your application. Try running "composer require symfony/twig-bundle".');
        }

        return $this->twig->render($name, $context);
    }
}
