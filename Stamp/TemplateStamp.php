<?php

namespace Flasher\Prime\Stamp;

final class TemplateStamp implements StampInterface, PresentableStampInterface
{
    /**
     * @var string
     */
    private $view;

    /**
     * @var string
     */
    private $template;

    /**
     * @param string $view
     * @param string $template
     */
    public function __construct($view, $template = null)
    {
        $this->view = $view;
        $this->template = $template;
    }

    /**
     * @return string
     */
    public function getView()
    {
        return $this->view;
    }

    /**
     * @return string
     */
    public function getTemplate()
    {
        return $this->template;
    }

    /**
     * @inheritDoc
     */
    public function toArray()
    {
        return array(
            'template' => $this->getTemplate(),
        );
    }
}
