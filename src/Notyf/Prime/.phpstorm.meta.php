<?php

/**
 * PhpStorm Meta File - IDE Enhancement for Notyf.
 *
 * This file provides PhpStorm with additional type information and method completion
 * capabilities for the Notyf library. It's not loaded during runtime but is used
 * exclusively by the IDE to improve developer experience.
 *
 * The file enhances code intelligence in several ways:
 * 1. Adds expected arguments for Notyf functions and methods
 * 2. Maps factory methods to their return types
 *
 * Design patterns:
 * - Metadata: Provides additional information about code that's only used by tools
 * - IDE Integration: Bridges the gap between dynamic PHP code and static analysis tools
 *
 * Note: This file is part of the development tooling and has no effect on runtime behavior.
 */

namespace PHPSTORM_META;

// Define expected values for notyf function's type parameter
expectedArguments(\notyf(), 1, 'success', 'error', 'info', 'warning');
expectedArguments(\Flasher\Notyf\Prime\notyf(), 1, 'success', 'error', 'info', 'warning');

// Define expected values for various builder methods
expectedArguments(\Flasher\Notyf\Prime\NotyfBuilder::duration(), 0, 1000, 2000, 3000, 4000, 5000);
expectedArguments(\Flasher\Notyf\Prime\NotyfBuilder::position(), 0, 'x', 'y');
expectedArguments(\Flasher\Notyf\Prime\NotyfBuilder::position(), 1, 'top', 'right', 'bottom', 'left', 'center');

// Map factory methods to their return types
override(\Flasher\Prime\FlasherInterface::use(), map(['notyf' => \Flasher\Notyf\Prime\NotyfInterface::class]));
override(\Flasher\Prime\FlasherInterface::create(), map(['notyf' => \Flasher\Notyf\Prime\NotyfInterface::class]));
override(\Flasher\Prime\Container\FlasherContainer::create(), map(['flasher.notyf' => \Notyf\Notyf\Prime\NotyfInterface::class]));
