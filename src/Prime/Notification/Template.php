<?php

namespace Flasher\Prime\Notification;

final class Template extends Notification
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
     *
     * @return void
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray()
    {
        return array_merge(parent::toArray(), array(
            'title' => $this->getTitle(),
        ));
    }
}
