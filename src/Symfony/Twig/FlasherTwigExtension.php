<?php

declare(strict_types=1);

namespace Flasher\Symfony\Twig;

use Flasher\Prime\FlasherInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

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
     * Renders the flash notifications based on the specified criteria, presenter, and context.
     *
     * @param array<string, mixed> $criteria  the criteria to filter the notifications
     * @param "html"|"json"|string $presenter The presenter format for rendering the notifications (e.g., 'html', 'json').
     * @param array<string, mixed> $context   additional context or options for rendering
     */
    public function render(array $criteria = [], string $presenter = 'html', array $context = []): mixed
    {
        return $this->flasher->render($presenter, $criteria, $context);
    }
}
