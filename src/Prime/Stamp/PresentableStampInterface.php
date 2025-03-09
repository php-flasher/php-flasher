<?php

declare(strict_types=1);

namespace Flasher\Prime\Stamp;

/**
 * PresentableStampInterface - Contract for stamps that contribute to presentation.
 *
 * This interface identifies stamps that should include their data in the notification's
 * serialized form when being presented. Stamps implementing this interface will have
 * their data included in the notification's metadata when rendered.
 *
 * Design patterns:
 * - Marker Interface: Identifies stamps that provide presentation metadata
 * - Serializable: Defines a standard way to convert objects to serializable data
 */
interface PresentableStampInterface
{
    /**
     * Converts the stamp to an array representation.
     *
     * This method should return an associative array containing the stamp's
     * data in a form that can be serialized and used in presentation.
     *
     * @return array<string, mixed> The array representation
     */
    public function toArray(): array;
}
