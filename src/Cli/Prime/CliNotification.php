<?php

namespace Flasher\Cli\Prime;

use Flasher\Prime\Notification\Notification;

final class CliNotification extends Notification
{
    /**
     * @var string
     */
    private $title;

    /** @var string */
    private $icon;

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

    /**
     * @return string
     */
    public function getIcon()
    {
        return $this->icon;
    }

    /**
     * @param string $icon
     */
    public function setIcon($icon)
    {
        $this->icon = $icon;
    }

    public function toArray()
    {
        return array_merge(parent::toArray(), array(
            'title' => $this->getTitle(),
            'icon' => $this->getIcon(),
        ));
    }
}
