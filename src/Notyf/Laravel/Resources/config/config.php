<?php

return array(
    'scripts' => array(
        'https://cdn.jsdelivr.net/npm/@flasher/flasher-notyf@0.1.5/dist/flasher-notyf.min.js',
    ),
    'styles' => array(),
    'options' => array(
        'duration' => 5000,
        'types' => array(
            array(
                'type'            => 'info',
                'className'       => 'notyf__toast--info',
                'backgroundColor' => '#5784E5',
                'icon'            => false,
            ),
            array(
                'type'            => 'warning',
                'className'       => 'notyf__toast--warning',
                'backgroundColor' => '#E3A008',
                'icon'            => false,
            )
        ),
    ),
);
