<?php

namespace Flasher\Prime\Response;

interface ResponseManagerInterface
{
    /**
     * @param array $criteria
     * @param string $format
     * @param array $context
     *
     * @return mixed
     */
    public function render(array $criteria = array(), $format = 'html', array $context = array());
}
