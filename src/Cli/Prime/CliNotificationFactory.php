<?php

namespace Flasher\Cli\Prime;

use Flasher\Prime\Factory\NotificationFactory;
use Flasher\Prime\Response\ResponseManagerInterface;
use Flasher\Prime\Storage\StorageManagerInterface;

final class CliNotificationFactory extends NotificationFactory implements CliFlasherInterface
{
    private $responseManager;
    private $filterCriteria;

    public function __construct(
        StorageManagerInterface $storageManager,
        ResponseManagerInterface $responseManager,
        array $filterCriteria = array()
    ) {
        parent::__construct($storageManager);

        $this->responseManager = $responseManager;
        $this->filterCriteria = $filterCriteria;
    }

    public function render(array $criteria = array(), $merge = true)
    {
        if ($merge) {
            $criteria = $this->filterCriteria + $criteria;
        }

        return $this->responseManager->render($criteria, 'cli');
    }

    public function createNotificationBuilder()
    {
        return new CliNotificationBuilder($this->getStorageManager(), new CliNotification(), 'cli');
    }
}
