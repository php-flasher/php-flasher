<?php

namespace Flasher\Prime\Stamp;

final class TemplateStamp implements StampInterface, PresentableStampInterface
{
    /**
     * @var string
     */
    private $template;

    /**
     * @param string $template
     */
    public function __construct($template)
    {
        $this->template = $template;
    }

    /**
     * @return string
     */
    public function getTemplate()
    {
        return $this->template;
    }

    public function toArray()
    {
        return array(
            'template' => $this->getTemplate(),
        );
    }
}
