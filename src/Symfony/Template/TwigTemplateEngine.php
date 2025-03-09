<?php

declare(strict_types=1);

namespace Flasher\Symfony\Template;

use Flasher\Prime\Template\TemplateEngineInterface;
use Twig\Environment;

/**
 * TwigTemplateEngine - Adapter for Symfony's Twig template engine.
 *
 * This class adapts Symfony's Twig environment to PHPFlasher's template engine
 * interface, enabling notification templates to be rendered using Twig.
 *
 * Design patterns:
 * - Adapter Pattern: Adapts Twig to PHPFlasher's template interface
 * - Null Object Pattern: Gracefully handles a missing Twig dependency
 * - Bridge Pattern: Bridges PHPFlasher's templating needs with Symfony's templating system
 */
final readonly class TwigTemplateEngine implements TemplateEngineInterface
{
    /**
     * Creates a new TwigTemplateEngine instance.
     *
     * @param Environment|null $twig The Twig environment or null if Twig is not available
     */
    public function __construct(private ?Environment $twig = null)
    {
    }

    /**
     * Renders a template using Twig.
     *
     * @param string               $name    The template name or path
     * @param array<string, mixed> $context The template variables
     *
     * @return string The rendered template
     *
     * @throws \LogicException If Twig is not available
     */
    public function render(string $name, array $context = []): string
    {
        if (null === $this->twig) {
            throw new \LogicException('The TwigBundle is not registered in your application. Try running "composer require symfony/twig-bundle".');
        }

        return $this->twig->render($name, $context);
    }
}
