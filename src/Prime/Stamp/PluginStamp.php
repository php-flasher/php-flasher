<?php

declare(strict_types=1);

namespace Flasher\Prime\Stamp;

/**
 * PluginStamp - Associates a notification with a specific plugin.
 *
 * This stamp identifies which plugin should handle a notification. It ensures
 * that notifications are rendered with the correct plugin's resources and options.
 * This information is also serialized into the notification's metadata.
 *
 * Design patterns:
 * - Value Object: Immutable object representing a specific concept
 * - Strategy Identifier: Identifies which rendering strategy to use
 */
final readonly class PluginStamp implements PresentableStampInterface, StampInterface
{
    /**
     * Creates a new PluginStamp instance.
     *
     * @param string $plugin The plugin alias (e.g., 'toastr', 'sweetalert')
     */
    public function __construct(private string $plugin)
    {
    }

    /**
     * Gets the plugin alias.
     *
     * @return string The plugin alias
     */
    public function getPlugin(): string
    {
        return $this->plugin;
    }

    /**
     * Converts the stamp to an array representation.
     *
     * This method implements the serialization logic required by PresentableStampInterface.
     *
     * @return array{plugin: string} The array representation
     */
    public function toArray(): array
    {
        return ['plugin' => $this->plugin];
    }
}
