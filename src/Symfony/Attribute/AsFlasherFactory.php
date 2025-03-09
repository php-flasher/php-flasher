<?php

declare(strict_types=1);

namespace Flasher\Symfony\Attribute;

/**
 * AsFlasherFactory - Attribute for tagging notification factories.
 *
 * This attribute enables auto-configuration of notification factory services in Symfony.
 * When applied to a factory class, it automatically registers the class with the container
 * using the specified alias, making it available to the PHPFlasher system.
 *
 * Design patterns:
 * - Attribute-based Configuration: Uses PHP 8 attributes for declarative service configuration
 * - Service Tagging: Implements Symfony's tag-based service discovery mechanism
 *
 * Usage:
 * ```php
 * #[AsFlasherFactory('toastr')]
 * class ToastrFactory implements NotificationFactoryInterface
 * {
 *     // ...
 * }
 * ```
 */
#[\Attribute(\Attribute::TARGET_CLASS)]
final readonly class AsFlasherFactory
{
    /**
     * Creates a new AsFlasherFactory attribute.
     *
     * @param string $alias The unique alias for the notification factory (e.g., 'toastr', 'noty')
     */
    public function __construct(public string $alias)
    {
    }
}
