<?php

declare(strict_types=1);

namespace Flasher\Prime\Stamp;

/**
 * StampInterface - Marker interface for notification metadata.
 *
 * This interface is a base marker for all stamp classes that can be attached
 * to notification envelopes. Stamps provide metadata and behavior modifiers
 * for notifications, following the Envelope Pattern where the core notification
 * is wrapped with various stamps that affect its behavior.
 *
 * Design patterns:
 * - Marker Interface: Identifies classes that can serve as notification stamps
 * - Envelope Pattern: Part of a system where a core object is wrapped with metadata
 */
interface StampInterface
{
    // This is a marker interface with no methods
}
