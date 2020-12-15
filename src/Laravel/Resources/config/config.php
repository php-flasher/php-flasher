<?php

return array(
    'default' => 'template',

    'scripts' => array(
        '/vendor/flasher/flasher.js',
    ),

    'auto_create_from_session' => true,

    'types_mapping' => array(
        'success' => array('success'),
        'error'   => array('error', 'danger'),
        'warning' => array('warning', 'alarm'),
        'info'    => array('info', 'notice', 'alert'),
    ),

    'observer_events' => array(
        'exclude' => array(
            'forceDeleted',
            'restored',
        ),
    ),

    'adapters' => array(
        'template' => array(
            'default' => 'tailwindcss',
            'views'   => array(
                'tailwindcss' => 'flasher::tailwindcss',
            ),
            'scripts' => array(
                '/vendor/flasher/flasher-template.js',
            ),
            'styles'  => array(
                'https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css',
            ),
            'options' => array(
                'timeout'  => 5000,
                'position' => 'top-right',
            ),
        ),
    ),
);
