<?php

declare(strict_types=1);

namespace Flasher\Symfony\Twig;

use Flasher\Prime\FlasherInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

/**
 * FlasherTwigExtension - Twig extension for rendering notifications.
 *
 * This class provides Twig functions that allow notification rendering
 * directly from Twig templates. It exposes PHPFlasher's rendering
 * capabilities to template files.
 *
 * Design patterns:
 * - Extension Pattern: Extends Twig's functionality
 * - Adapter Pattern: Adapts PHPFlasher's API for Twig templates
 * - Delegation: Delegates actual rendering to the Flasher service
 */
final class FlasherTwigExtension extends AbstractExtension
{
    /**
     * Creates a new FlasherTwigExtension instance.
     *
     * @param FlasherInterface $flasher The PHPFlasher service
     */
    public function __construct(private readonly FlasherInterface $flasher)
    {
    }

    /**
     * Returns the Twig functions provided by this extension.
     *
     * @return TwigFunction[] Array of Twig functions
     */
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
     *
     * @return mixed The rendered output (HTML string, JSON string, etc.)
     */
    public function render(array $criteria = [], string $presenter = 'html', array $context = []): mixed
    {
        return $this->flasher->render($presenter, $criteria, $context);
    }
}
