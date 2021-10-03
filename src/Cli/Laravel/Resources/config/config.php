<?php

return array(
    'render_all' => true,

    'render_immediately' => true,

    'title' => 'PHP Flasher',

    'mute' => false,

    'filter_criteria' => array(),

    'icons' => array(),

    'sounds' => array(),

    'notifiers' => array(
        'growl_notify' => array(
            'enabled' => true,
            'priority' => 0,
            'binary' => 'growlnotify',
            'binary_paths' => array(),
            'title' => null,
            'mute' => true,
            'icons' => array(),
            'sounds' => array(),
        ),
        'kdialog_notifier' => array(
            'enabled' => true,
            'priority' => 0,
            'binary' => 'kdialog',
            'binary_paths' => array(),
            'title' => null,
            'mute' => true,
            'icons' => array(),
            'sounds' => array(),
        ),
        'notifu_notifier' => array(
            'enabled' => true,
            'priority' => 0,
            'binary' => 'notifu',
            'binary_paths' => array(),
            'title' => null,
            'mute' => true,
            'icons' => array(),
            'sounds' => array(),
        ),
        'notify_send' => array(
            'enabled' => true,
            'priority' => 2,
            'binary' => 'notify-send',
            'binary_paths' => array(),
            'title' => null,
            'mute' => true,
            'icons' => array(),
            'sounds' => array(),
        ),
        'zenity' => array(
            'enabled' => true,
            'priority' => 1,
            'binary' => 'zenity',
            'binary_paths' => array(),
            'title' => null,
            'mute' => true,
            'icons' => array(),
            'sounds' => array(),
        ),
        'snore_toast_notifier' => array(
            'enabled' => true,
            'priority' => 0,
            'binary' => 'snoretoast',
            'binary_paths' => array(),
            'title' => null,
            'mute' => true,
            'icons' => array(),
            'sounds' => array(),
        ),
        'terminal_notifier_notifier' => array(
            'enabled' => true,
            'priority' => 0,
            'binary' => 'terminal-notifier',
            'binary_paths' => array(),
            'title' => null,
            'mute' => true,
            'icons' => array(),
            'sounds' => array(),
        ),
        'toaster' => array(
            'enabled' => true,
            'priority' => 0,
            'binary' => 'toast',
            'binary_paths' => array(),
            'title' => null,
            'mute' => true,
            'icons' => array(),
            'sounds' => array(),
        ),
    ),
);
