<?php

if (!function_exists('flasher')) {
    /**
     * @param string $message
     * @param string $type
     *
     * @return \Flasher\Prime\Flasher
     */
    function flasher($message = null, $type = 'success', array $options = array(), array $stamps = array())
    {
        /** @var \Flasher\Prime\FlasherInterface $flasher */
        $flasher = app('flasher');

        if (null === $message && 0 === func_num_args()) {
            return $flasher;
        }

        return $flasher->with($stamps)->addFlash($type, $message, $options);
    }
}

if (!function_exists('flash')) {
    /**
     * @param string $message
     * @param string $type
     *
     * @return \Flasher\Prime\Factory\TemplateFactory
     */
    function flash($message = null, $title = null, $type = 'success', array $options = array(), array $stamps = array())
    {
        /** @var \Flasher\Prime\Factory\TemplateFactory $flasher */
        $flasher = app('flasher.template');

        if (null === $message && 0 === func_num_args()) {
            return $flasher;
        }

        return $flasher
            ->title($title)
            ->with($stamps)
            ->addFlash($type, $message, $options);
    }
}
