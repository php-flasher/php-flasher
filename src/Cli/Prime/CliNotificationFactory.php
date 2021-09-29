<?php

namespace Flasher\Cli\Prime;

use Flasher\Prime\Factory\NotificationFactory;
use Flasher\Prime\Response\ResponseManagerInterface;
use Flasher\Prime\Storage\StorageManagerInterface;

final class CliNotificationFactory extends NotificationFactory implements CliFlasherInterface
{
    private $responseManager;

    public function __construct(StorageManagerInterface $storageManager, ResponseManagerInterface $responseManager)
    {
        parent::__construct($storageManager);

        $this->responseManager = $responseManager;
    }

    public function render(array $criteria = array(), $presenter = 'html', array $context = array())
    {
        return $this->responseManager->render($criteria, $presenter, $context);
    }

    public function createNotificationBuilder()
    {
        return new CliNotificationBuilder($this->getStorageManager(), new CliNotification(), 'cli');
    }
}
