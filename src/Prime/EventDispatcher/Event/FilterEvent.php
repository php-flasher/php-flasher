<?php

declare(strict_types=1);

namespace Flasher\Prime\EventDispatcher\Event;

use Flasher\Prime\Notification\Envelope;
use Flasher\Prime\Storage\Filter\Filter;
use Flasher\Prime\Storage\Filter\FilterInterface;

/**
 * FilterEvent - Event dispatched when notifications are being filtered.
 *
 * This event is dispatched during the filtering process, allowing listeners
 * to modify the filter, the envelopes being filtered, or the filter criteria.
 */
final class FilterEvent
{
    /**
     * Creates a new FilterEvent instance.
     *
     * @param FilterInterface      $filter    The filter being applied
     * @param Envelope[]           $envelopes The notification envelopes to filter
     * @param array<string, mixed> $criteria  The filtering criteria
     */
    public function __construct(
        private FilterInterface $filter,
        private array $envelopes,
        private readonly array $criteria,
    ) {
    }

    /**
     * Gets the filter being applied.
     *
     * @return FilterInterface The filter
     */
    public function getFilter(): FilterInterface
    {
        return $this->filter;
    }

    /**
     * Sets the filter to be applied.
     *
     * This allows listeners to replace the filter with a custom implementation.
     *
     * @param Filter $filter The new filter
     */
    public function setFilter(Filter $filter): void
    {
        $this->filter = $filter;
    }

    /**
     * Gets the notification envelopes being filtered.
     *
     * @return Envelope[] The notification envelopes
     */
    public function getEnvelopes(): array
    {
        return $this->envelopes;
    }

    /**
     * Sets the notification envelopes to be filtered.
     *
     * This allows listeners to modify the collection of envelopes before filtering.
     *
     * @param Envelope[] $envelopes The notification envelopes to filter
     */
    public function setEnvelopes(array $envelopes): void
    {
        $this->envelopes = $envelopes;
    }

    /**
     * Gets the filtering criteria.
     *
     * These criteria determine how notifications will be filtered.
     *
     * @return array<string, mixed> The filtering criteria
     */
    public function getCriteria(): array
    {
        return $this->criteria;
    }
}
