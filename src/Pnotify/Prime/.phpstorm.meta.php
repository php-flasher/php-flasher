<?php

namespace PHPSTORM_META;

expectedArguments(\pnotify(), 1, 'success', 'error', 'info', 'warning');
expectedArguments(\Flasher\Pnotify\Prime\PnotifyBuilder::styling(), 0, 'brighttheme', 'bootstrap3', 'fontawesome');
expectedArguments(\Flasher\Pnotify\Prime\PnotifyBuilder::type(), 0, 'notice', 'info', 'success', 'error');
expectedArguments(\Flasher\Pnotify\Prime\PnotifyBuilder::animation(), 0, 'none', 'fade');
expectedArguments(\Flasher\Pnotify\Prime\PnotifyBuilder::animateSpeed(), 0,  'slow', 'normal', 'fast');
expectedArguments(\Flasher\Pnotify\Prime\PnotifyBuilder::desktop(), 0,  'desktop', 'fallback', 'icon', 'tag', 'title', 'text');
expectedArguments(\Flasher\Pnotify\Prime\PnotifyBuilder::buttons(), 0,  'closer', 'closer_hover', 'sticker', 'sticker_hover', 'show_on_nonblock', 'labels', 'classes');
expectedArguments(\Flasher\Pnotify\Prime\PnotifyBuilder::nonblock(), 0,  'nonblock');
expectedArguments(\Flasher\Pnotify\Prime\PnotifyBuilder::mobile(), 0,  'swipe_dismiss', 'styling');
expectedArguments(\Flasher\Pnotify\Prime\PnotifyBuilder::animate(), 0,  'animate', 'in_class', 'out_class');
expectedArguments(\Flasher\Pnotify\Prime\PnotifyBuilder::confirm(), 0,  'confirm', 'prompt', 'prompt_class', 'prompt_default', 'prompt_multi_line', 'align', 'buttons');
expectedArguments(\Flasher\Pnotify\Prime\PnotifyBuilder::history(), 0,  'history', 'menu', 'fixed', 'maxonscreen', 'labels');

override(\Flasher\Prime\FlasherInterface::create(), map([
    'pnotify' => \Flasher\Pnotify\Prime\PnotifyFactory::class
]));

override(\Flasher\Prime\FlasherInterface::using(), map([
    'pnotify' => \Flasher\Pnotify\Prime\PnotifyFactory::class
]));
