<?php

/**
 * PhpStorm Meta File - IDE Enhancement for SweetAlert2.
 *
 * This file provides PhpStorm with additional type information and method completion
 * capabilities for the SweetAlert2 library. It's not loaded during runtime but is used
 * exclusively by the IDE to improve developer experience.
 *
 * The file enhances code intelligence in several ways:
 * 1. Adds expected arguments for SweetAlert functions and methods
 * 2. Maps factory methods to their return types
 *
 * Design patterns:
 * - Metadata: Provides additional information about code that's only used by tools
 * - IDE Integration: Bridges the gap between dynamic PHP code and static analysis tools
 *
 * Note: This file is part of the development tooling and has no effect on runtime behavior.
 */

namespace PHPSTORM_META;

// Define expected values for sweetalert function's type parameter
expectedArguments(\sweetalert(), 1, 'success', 'error', 'info', 'warning');
expectedArguments(\Flasher\SweetAlert\Prime\sweetalert(), 1, 'success', 'error', 'info', 'warning');

// Define expected values for various builder methods
expectedArguments(\Flasher\SweetAlert\Prime\SweetAlertBuilder::icon(), 0, 'warning', 'error', 'success', 'info', 'question');
expectedArguments(\Flasher\SweetAlert\Prime\SweetAlertBuilder::showClass(), 0, 'popup', 'backdrop', 'icon');
expectedArguments(\Flasher\SweetAlert\Prime\SweetAlertBuilder::hideClass(), 0, 'popup', 'backdrop', 'icon');
expectedArguments(\Flasher\SweetAlert\Prime\SweetAlertBuilder::input(), 0, 'text', 'email', 'password', 'number', 'tel', 'range', 'textarea', 'select', 'radio', 'checkbox', 'file', 'url');
expectedArguments(\Flasher\SweetAlert\Prime\SweetAlertBuilder::position(), 0, 'top', 'top-start', 'top-end', 'center', 'center-start', 'center-end', 'bottom', 'bottom-start', 'bottom-end');
expectedArguments(\Flasher\SweetAlert\Prime\SweetAlertBuilder::toast(), 1, 'top', 'top-start', 'top-end', 'center', 'center-start', 'center-end', 'bottom', 'bottom-start', 'bottom-end');
expectedArguments(\Flasher\SweetAlert\Prime\SweetAlertBuilder::grow(), 0, 'row', 'column', 'fullscreen', false);
expectedArguments(\Flasher\SweetAlert\Prime\SweetAlertBuilder::customClass(), 0, 'container', 'popup', 'header', 'title', 'closeButton', 'icon', 'image', 'content', 'input', 'inputLabel', 'validationMessage', 'actions', 'confirmButton', 'denyButton', 'cancelButton', 'loader', 'footer');

// Map factory methods to their return types
override(\Flasher\Prime\FlasherInterface::use(), map(['sweetalert' => \Flasher\SweetAlert\Prime\SweetAlertInterface::class]));
override(\Flasher\Prime\FlasherInterface::create(), map(['sweetalert' => \Flasher\SweetAlert\Prime\SweetAlertInterface::class]));
override(\Flasher\Prime\Container\FlasherContainer::create(), map(['flasher.sweetalert' => \Flasher\SweetAlert\Prime\SweetAlertInterface::class]));
