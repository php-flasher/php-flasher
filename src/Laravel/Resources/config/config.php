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
            'default'   => 'tailwindcss',
            'templates' => array(
                'tailwindcss'    => array(
                    'view'   => 'flasher::tailwindcss',
                    'styles' => array(
                        'https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css',
                    ),
                ),
                'tailwindcss_bg' => array(
                    'view'   => 'flasher::tailwindcss_bg',
                    'styles' => array(
                        'https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css',
                    ),
                ),
                'bootstrap'      => array(
                    'view'   => 'flasher::bootstrap',
                    'styles' => array(
                        'https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.3/css/bootstrap.min.css',
                    ),
                ),
            ),
            'scripts'   => array(
                '/vendor/flasher/flasher-template.js',
            ),
            'styles'    => array(),
            'options'   => array(
                'timeout'  => 5000,
                'position' => 'top-right',
            ),
        ),
    ),
);
