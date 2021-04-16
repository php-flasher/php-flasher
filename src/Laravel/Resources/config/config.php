<?php

return array(
    'default' => 'template',

    'root_scripts' => array(
        'https://cdn.jsdelivr.net/npm/@flasher/flasher@0.1.3/dist/flasher.min.js'
    ),

    'template_factory' => array(
        'default' => 'tailwindcss',
        'templates' => array(
            'tailwindcss' => array(
                'view' => 'flasher::tailwindcss',
                'styles' => array(
                    'https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.1.1/base.min.css',
                    'https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.1.1/utilities.css'
                ),
            ),
            'tailwindcss_bg' => array(
                'view' => 'flasher::tailwindcss_bg',
                "styles" => array(
                    'https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.1.1/base.min.css',
                    'https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.1.1/utilities.css',
                ),
            ),
            'bootstrap' => array(
                'view' => 'flasher::bootstrap',
                'styles' => array(
                    "https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.3/css/bootstrap.min.css",
                ),
            ),
        ),
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
);
