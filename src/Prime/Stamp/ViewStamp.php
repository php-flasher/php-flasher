<?php

namespace Flasher\Prime\Stamp;

final class ViewStamp implements StampInterface, PresentableStampInterface
{
    /**
     * @var string
     */
    private $view;

    /**
     * @param string $template
     */
    public function __construct($template)
    {
        $this->view = $template;
    }

    /**
     * @return string
     */
    public function getView()
    {
        return $this->view;
    }

    public function toArray()
    {
        return ['view' => $this->getView()];
    }
}
