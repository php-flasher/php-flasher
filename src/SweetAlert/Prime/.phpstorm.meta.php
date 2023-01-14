<?php

namespace PHPSTORM_META;

expectedArguments(\sweetalert(), 1, 'success', 'error', 'info', 'warning');
expectedArguments(\Flasher\SweetAlert\Prime\SweetAlertBuilder::icon(), 0, 'warning', 'error', 'success', 'info', 'question');
expectedArguments(\Flasher\SweetAlert\Prime\SweetAlertBuilder::showClass(), 0, 'popup', 'backdrop', 'icon');
expectedArguments(\Flasher\SweetAlert\Prime\SweetAlertBuilder::hideClass(), 0, 'popup', 'backdrop', 'icon');
expectedArguments(\Flasher\SweetAlert\Prime\SweetAlertBuilder::input(), 0, 'text', 'email', 'password', 'number', 'tel', 'range', 'textarea', 'select', 'radio', 'checkbox', 'file', 'url');
expectedArguments(\Flasher\SweetAlert\Prime\SweetAlertBuilder::position(), 0, 'top', 'top-start', 'top-end', 'center', 'center-start', 'center-end', 'bottom', 'bottom-start', 'bottom-end');
expectedArguments(\Flasher\SweetAlert\Prime\SweetAlertBuilder::toast(), 1, 'top', 'top-start', 'top-end', 'center', 'center-start', 'center-end', 'bottom', 'bottom-start', 'bottom-end');
expectedArguments(\Flasher\SweetAlert\Prime\SweetAlertBuilder::grow(), 0, 'row', 'column', 'fullscreen', false);
expectedArguments(\Flasher\SweetAlert\Prime\SweetAlertBuilder::customClass(), 0, 'container', 'popup', 'header', 'title', 'closeButton', 'icon', 'image', 'content', 'input', 'inputLabel', 'validationMessage', 'actions', 'confirmButton', 'denyButton', 'cancelButton', 'loader', 'footer');

override(\Flasher\Prime\FlasherInterface::create(), map([
    'sweetalert' => \Flasher\SweetAlert\Prime\SweetAlertFactory::class
]));

override(\Flasher\Prime\FlasherInterface::using(), map([
    'sweetalert' => \Flasher\SweetAlert\Prime\SweetAlertFactory::class
]));
