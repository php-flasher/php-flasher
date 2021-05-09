<?php

namespace Flasher\Prime\Response;

interface ResponseManagerInterface
{
    /**
     * @param string $format
     *
     * @return mixed
     */
    public function render(array $criteria = array(), $format = 'html', array $context = array());
}
