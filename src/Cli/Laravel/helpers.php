<?php

if (!function_exists('cliFlasher')) {
    /**
     * @param string $message
     * @param string $type
     *
     * @return Flasher\Cli\Prime\CliFlasherInterface
     */
    function cliFlasher($message = null, $renderImmediately = true, $type = 'success', array $options = array(), array $stamps = array())
    {
        /** @var Flasher\Cli\Prime\CliFlasherInterface $flasher */
        $flasher = app('flasher.cli');

        if (null === $message && 0 === func_num_args()) {
            return $flasher;
        }

        return $flasher->with($stamps)->desktop($renderImmediately)->addFlash($type, $message, $options);
    }
}
