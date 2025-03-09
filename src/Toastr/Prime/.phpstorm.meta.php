<?php

/**
 * PhpStorm Meta File - IDE Enhancement for Toastr.
 *
 * This file provides PhpStorm with additional type information and method completion
 * capabilities for the Toastr library. It's not loaded during runtime but is used
 * exclusively by the IDE to improve developer experience.
 *
 * The file enhances code intelligence in several ways:
 * 1. Adds expected arguments for Toastr functions and methods
 * 2. Maps factory methods to their return types
 *
 * Design patterns:
 * - Metadata: Provides additional information about code that's only used by tools
 * - IDE Integration: Bridges the gap between dynamic PHP code and static analysis tools
 *
 * Note: This file is part of the development tooling and has no effect on runtime behavior.
 */

namespace PHPSTORM_META;

// Define expected values for toastr function's type parameter
expectedArguments(\toastr(), 1, 'success', 'error', 'info', 'warning');
expectedArguments(\Flasher\Toastr\Prime\toastr(), 1, 'success', 'error', 'info', 'warning');

// Define expected values for various builder methods
expectedArguments(\Flasher\Toastr\Prime\ToastrBuilder::showMethod(), 0, 'fadeIn', 'fadeOut', 'slideDown', 'show');
expectedArguments(\Flasher\Toastr\Prime\ToastrBuilder::hideMethod(), 0, 'fadeIn', 'fadeOut', 'slideDown', 'show');
expectedArguments(\Flasher\Toastr\Prime\ToastrBuilder::showEasing(), 0, 'swing', 'linear');
expectedArguments(\Flasher\Toastr\Prime\ToastrBuilder::hideEasing(), 0, 'swing', 'linear');
expectedArguments(\Flasher\Toastr\Prime\ToastrBuilder::timeOut(), 0, 0, 3000, 5000, 9000);
expectedArguments(\Flasher\Toastr\Prime\ToastrBuilder::positionClass(), 0, 'toast-top-right', 'toast-top-center', 'toast-bottom-center', 'toast-top-full-width', 'toast-bottom-full-width', 'toast-top-left', 'toast-bottom-right', 'toast-bottom-left');

// Map factory methods to their return types
override(\Flasher\Prime\FlasherInterface::use(), map(['toastr' => \Flasher\Toastr\Prime\ToastrInterface::class]));
override(\Flasher\Prime\FlasherInterface::create(), map(['toastr' => \Flasher\Toastr\Prime\ToastrInterface::class]));
override(\Flasher\Prime\Container\FlasherContainer::create(), map(['flasher.toastr' => \Flasher\Toastr\Prime\ToastrInterface::class]));

// Define expected option names for the option method
expectedArguments(\Flasher\Toastr\Prime\ToastrBuilder::option(), 0, 'closeButton', 'closeClass', 'closeDuration', 'closeEasing', 'closeHtml', 'closeMethod', 'closeOnHover', 'containerId', 'debug', 'escapeHtml', 'extendedTimeOut', 'hideDuration', 'hideEasing', 'hideMethod', 'iconClass', 'messageClass', 'newestOnTop', 'onHidden', 'onShown', 'positionClass', 'preventDuplicates', 'progressBar', 'progressClass', 'rtl', 'showDuration', 'showEasing', 'showMethod', 'tapToDismiss', 'target', 'timeOut', 'titleClass', 'toastClass');
