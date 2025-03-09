<?php

declare(strict_types=1);

namespace Flasher\Symfony\Attribute;

/**
 * AsFlasherPresenter - Attribute for tagging response presenters.
 *
 * This attribute enables auto-configuration of response presenter services in Symfony.
 * When applied to a presenter class, it automatically registers the class with the
 * container using the specified alias, making it available to PHPFlasher's response system.
 *
 * Design patterns:
 * - Attribute-based Configuration: Uses PHP 8 attributes for declarative service configuration
 * - Service Tagging: Implements Symfony's tag-based service discovery mechanism
 * - Strategy Pattern: Supports pluggable response formatting strategies
 *
 * Usage:
 * ```php
 * #[AsFlasherPresenter('html')]
 * class HtmlPresenter implements PresenterInterface
 * {
 *     // ...
 * }
 * ```
 */
#[\Attribute(\Attribute::TARGET_CLASS)]
final readonly class AsFlasherPresenter
{
    /**
     * Creates a new AsFlasherPresenter attribute.
     *
     * @param string $alias The unique alias for the presenter (e.g., 'html', 'json')
     */
    public function __construct(public string $alias)
    {
    }
}
