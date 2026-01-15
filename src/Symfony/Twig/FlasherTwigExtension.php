<?php

declare(strict_types=1);

namespace Flasher\Symfony\Twig;

use Flasher\Prime\FlasherInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

/**
 * Twig extension for rendering PHPFlasher notifications.
 */
final class FlasherTwigExtension extends AbstractExtension
{
    public function __construct(private readonly FlasherInterface $flasher)
    {
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('flasher_render', $this->render(...), ['is_safe' => ['html']]),
        ];
    }

    /**
     * @param array<string, mixed> $criteria
     * @param array<string, mixed> $context
     */
    public function render(array $criteria = [], string $presenter = 'html', array $context = []): mixed
    {
        return $this->flasher->render($presenter, $criteria, $context);
    }
}
