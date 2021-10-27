<?php

return array(
    'default' => 'template',

    'root_script' => 'https://cdn.jsdelivr.net/npm/@flasher/flasher@0.6.1/dist/flasher.min.js',

    'template_factory' => array(
        'default' => 'tailwindcss',
        'templates' => array(
            'tailwindcss' => array(
                'view' => 'flasher::tailwindcss',
                'styles' => array(
                    'https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.11/base.min.css',
                    'https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.11/utilities.css',
                ),
            ),
            'tailwindcss_bg' => array(
                'view' => 'flasher::tailwindcss_bg',
                'styles' => array(
                    'https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.11/base.min.css',
                    'https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.11/utilities.css',
                ),
            ),
            'bootstrap' => array(
                'view' => 'flasher::bootstrap',
                'styles' => array(
                    'https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/css/bootstrap.min.css',
                ),
            ),
        ),
    ),

    'auto_create_from_session' => true,

    'types_mapping' => array(
        'success' => array('success'),
        'error' => array('error', 'danger'),
        'warning' => array('warning', 'alarm'),
        'info' => array('info', 'notice', 'alert'),
    ),

    'observer_events' => array(
        'exclude' => array(
            'forceDeleted',
            'restored',
        ),
    ),
);
