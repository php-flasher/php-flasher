<?php

namespace Flasher\Prime\EventDispatcher\EventListener;

use Flasher\Prime\EventDispatcher\Event\FilterEvent;
use Flasher\Prime\Filter\FilterInterface;

final class ResponseListener implements EventSubscriberInterface
{
    /**
     * @var FilterInterface
     */
    private $filter;

    public function __construct(FilterInterface $filter)
    {
        $this->filter = $filter;
    }

    /**
     * @return void
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
     * @return string
     */
    public static function getSubscribedEvents()
    {
        return 'Flasher\Prime\EventDispatcher\Event\FilterEvent';
    }
}
