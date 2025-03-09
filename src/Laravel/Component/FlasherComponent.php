<?php

declare(strict_types=1);

namespace Flasher\Laravel\Component;

use Illuminate\View\Component;

/**
 * FlasherComponent - Blade component for rendering notifications.
 *
 * This class provides a Blade component interface for rendering PHPFlasher
 * notifications in Laravel views. It can be used with Laravel's component syntax:
 * <x-flasher :criteria="json_encode(['limit' => 5])" :context="json_encode(['foo' => 'bar'])" />
 *
 * Design patterns:
 * - View Component: Implements Laravel's view component pattern
 * - Adapter: Adapts the Flasher render method to Laravel's component interface
 */
final class FlasherComponent extends Component
{
    /**
     * Creates a new FlasherComponent instance.
     *
     * @param string $criteria JSON-encoded filtering criteria for notifications
     * @param string $context  JSON-encoded rendering context
     */
    public function __construct(public string $criteria = '', public string $context = '')
    {
    }

    /**
     * Renders the component.
     *
     * This method decodes the JSON criteria and context, then delegates to
     * the Flasher service to render the notifications as HTML.
     *
     * @return string Rendered HTML content
     *
     * @throws \JsonException If JSON decoding fails
     */
    public function render(): string
    {
        /** @var array<string, mixed> $criteria */
        $criteria = json_decode($this->criteria, true, 512, \JSON_THROW_ON_ERROR) ?: [];

        /** @var array<string, mixed> $context */
        $context = json_decode($this->context, true, 512, \JSON_THROW_ON_ERROR) ?: [];

        return app('flasher')->render('html', $criteria, $context);
    }
}
