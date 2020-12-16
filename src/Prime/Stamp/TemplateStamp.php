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
     * @var array
     */
    private $context = array();

    /**
     * @param string $view
     * @param string $template
     */
    public function __construct($view, $template = null, array $context = array())
    {
        $this->view = $view;
        $this->template = $template;
        $this->context = $context;
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
     * @return array
     */
    public function getContext()
    {
        return $this->context;
    }

    /**
     * @inheritDoc
     */
    public function toArray()
    {
        return array(
            'template' => $this->getTemplate(),
            'context'  => $this->getContext(),
        );
    }
}
