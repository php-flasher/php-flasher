<?php

namespace Flasher\Prime\Response;

interface ResponseManagerInterface
{
    /**
     * @param mixed[] $criteria
     * @param string $presenter
     * @param mixed[] $context
     *
     * @return mixed
     */
    public function render(array $criteria = array(), $presenter = 'html', array $context = array());
}
