<?php

return array(
    'default' => 'toastr',

    'scripts' => array(
        '/vendor/php-flasher/flasher/assets/js/flasher.js'
    ),

    'auto_create_from_session' => true,

    'types_mapping' => array(
        'success' => array('success'),
        'error'   => array('error', 'danger'),
        'warning' => array('warning', 'alarm'),
        'info'    => array('info', 'notice', 'alert'),
    ),
);
