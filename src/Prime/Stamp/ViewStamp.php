<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

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

    /**
     * {@inheritdoc}
     */
    public function toArray()
    {
        return array('view' => $this->getView());
    }
}
