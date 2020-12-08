<?php

namespace Flasher\Prime\EventDispatcher\EventListener;

use Flasher\Prime\EventDispatcher\Event\FilterEvent;
use Flasher\Prime\Envelope;
use Flasher\Prime\Filter\FilterInterface;

final class FilterListener implements EventSubscriberInterface
{
    /**
     * @var FilterInterface
     */
    private $filter;

    /**
     * @param FilterInterface $filter
     */
    public function __construct(FilterInterface $filter)
    {
        $this->filter = $filter;
    }

    /**
     * @param FilterEvent $event
     *
     * @return Envelope[]
     */
    public function __invoke(FilterEvent $event)
    {
        $criteria = $event->getCriteria();
        $criteria['delay'] = 0;
        $criteria['hops']['min'] = 1;

        $envelopes = $this->filter->filter($event->getEnvelopes(), $criteria);

        $event->setEnvelopes($envelopes);
    }

    /**
     * @inheritDoc
     */
    public static function getSubscribedEvents()
    {
        return 'Flasher\Prime\EventDispatcher\Event\FilterEvent';
    }
}
