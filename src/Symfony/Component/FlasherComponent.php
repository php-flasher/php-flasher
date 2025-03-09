<?php

declare(strict_types=1);

namespace Flasher\Symfony\Component;

/**
 * FlasherComponent - Twig component for rendering notifications.
 *
 * This class implements a Twig component that can be used in templates to render
 * PHPFlasher notifications. It supports customizing the filtering criteria,
 * presenter format, and rendering context.
 *
 * Design patterns:
 * - Component-based Architecture: Implements Twig's component pattern
 * - Data Transfer Object: Holds configuration for notification rendering
 *
 * Usage in templates:
 * ```twig
 * <twig:flasher
 *   criteria="{{ {limit: 5} }}"
 *   presenter="html"
 *   context="{{ {foo: 'bar'} }}" />
 * ```
 */
final class FlasherComponent
{
    /**
     * Filtering criteria for notifications.
     *
     * @var array<string, mixed>
     */
    public array $criteria = [];

    /**
     * Presentation format (e.g., 'html', 'json').
     */
    public string $presenter = 'html';

    /**
     * Additional context for rendering.
     *
     * @var array<string, mixed>
     */
    public array $context = [];
}
