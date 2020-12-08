<?php

namespace Flasher\Prime\EventDispatcher\EventListener;

use Flasher\Prime\EventDispatcher\Event\PostBuildEvent;
use Flasher\Prime\Storage\StorageManagerInterface;

final class PostBuildListener implements EventSubscriberInterface
{
    /**
     * @var StorageManagerInterface
     */
    private $storageManager;

    /**
     * @param StorageManagerInterface $storageManager
     */
    public function __construct(StorageManagerInterface $storageManager)
    {
        $this->storageManager = $storageManager;
    }

    /**
     * @param PostBuildEvent $event
     */
    public function __invoke(PostBuildEvent $event)
    {
        $this->storageManager->add($event->getEnvelope());
    }

    /**
     * @inheritDoc
     */
    public static function getSubscribedEvents()
    {
        return 'Flasher\Prime\EventDispatcher\Event\PostBuildEvent';
    }
}
