<?php

return array(
    'scripts' => array(
        'https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js',
        'https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/10.10.2/sweetalert2.min.js',
        'https://cdnjs.cloudflare.com/ajax/libs/promise-polyfill/8.2.0/polyfill.min.js',
    ),
    'styles' => array(
        'https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css',
        'https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/10.10.2/sweetalert2.min.css',
    ),
    'options' => array(
        'timer'             => 5000,
      //'width'             => '32rem',
      //'heightAuto'        => true,
        'padding'           => '1.25rem',
        'showConfirmButton' => false,
        'showCloseButton'   => false,
        'toast'             => true,
        'position'          => 'top-end',
        'timerProgressBar'  => true,
        'animation'         => true,
        'showClass'         => array(
            'popup' => 'animate__animated animate__fadeInDown',
        ),
        'hideClass'         => array(
            'popup' => 'animate__animated animate__fadeOutUp',
        ),
        'backdrop'          => true,
        'grow'              => true,
    ),
);
