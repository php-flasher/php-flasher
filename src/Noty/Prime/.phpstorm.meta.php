<?php

/**
 * PhpStorm Meta File - IDE Enhancement for Noty.
 *
 * This file provides PhpStorm with additional type information and method completion
 * capabilities for the Noty library. It's not loaded during runtime but is used
 * exclusively by the IDE to improve developer experience.
 *
 * The file enhances code intelligence in several ways:
 * 1. Adds expected arguments for Noty functions and methods
 * 2. Maps factory methods to their return types
 *
 * Design patterns:
 * - Metadata: Provides additional information about code that's only used by tools
 * - IDE Integration: Bridges the gap between dynamic PHP code and static analysis tools
 *
 * Note: This file is part of the development tooling and has no effect on runtime behavior.
 */

namespace PHPSTORM_META;

// Define expected values for noty function's type parameter
expectedArguments(\noty(), 1, 'success', 'error', 'info', 'warning');
expectedArguments(\Flasher\Noty\Prime\noty(), 1, 'success', 'error', 'info', 'warning');

// Define expected values for various builder methods
expectedArguments(\Flasher\Noty\Prime\NotyBuilder::layout(), 0, 'top', 'topLeft', 'topCenter', 'topRight', 'center', 'centerLeft', 'centerRight', 'bottom', 'bottomLeft', 'bottomCenter', 'bottomRight');
expectedArguments(\Flasher\Noty\Prime\NotyBuilder::theme(), 0, 'relax', 'mint', 'metroui');
expectedArguments(\Flasher\Noty\Prime\NotyBuilder::timeout(), 0, false, 1000, 3000, 3500, 5000);
expectedArguments(\Flasher\Noty\Prime\NotyBuilder::closeWith(), 0, 'click', 'button', ['click', 'button']);
expectedArguments(\Flasher\Noty\Prime\NotyBuilder::animation(), 0, 'open', 'close');
expectedArguments(\Flasher\Noty\Prime\NotyBuilder::sounds(), 0, 'sources', 'volume', 'conditions');
expectedArguments(\Flasher\Noty\Prime\NotyBuilder::docTitle(), 0, 'conditions');
expectedArguments(\Flasher\Noty\Prime\NotyBuilder::queue(), 0, 'global');

// Map factory methods to their return types
override(\Flasher\Prime\FlasherInterface::use(), map(['noty' => \Flasher\Noty\Prime\NotyInterface::class]));
override(\Flasher\Prime\FlasherInterface::create(), map(['noty' => \Flasher\Noty\Prime\NotyInterface::class]));
override(\Flasher\Prime\Container\FlasherContainer::create(), map(['flasher.noty' => \Flasher\Noty\Prime\NotyInterface::class]));
