<?php

namespace Flasher\Cli\Prime;

use Flasher\Prime\Notification\Notification;

final class CliNotification extends Notification
{
    /**
     * @var string
     */
    private $title;

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function toArray()
    {
        return array_merge(parent::toArray(), array(
            'title' => $this->getTitle(),
        ));
    }
}
