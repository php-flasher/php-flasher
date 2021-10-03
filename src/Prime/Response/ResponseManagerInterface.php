<?php

namespace Flasher\Prime\Response;

interface ResponseManagerInterface
{
    /**
     * @param string $presenter
     *
     * @return mixed
     */
    public function render(array $criteria = array(), $presenter = 'html', array $context = array());
}
