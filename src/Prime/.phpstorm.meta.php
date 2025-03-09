<?php

/**
 * PhpStorm Meta File - IDE Enhancement for PHPFlasher.
 *
 * This file provides PhpStorm with additional type information and method completion
 * capabilities for the PHPFlasher library. It's not loaded during runtime but is used
 * exclusively by the IDE to improve developer experience.
 *
 * The file enhances code intelligence in several ways:
 * 1. Adds type inference for Envelope::get() method
 * 2. Provides completion for factory methods in FlasherInterface
 * 3. Registers expected argument sets for notification types
 * 4. Defines expected arguments for various builder methods
 *
 * Design patterns:
 * - Metadata: Provides additional information about code that's only used by tools
 * - IDE Integration: Bridges the gap between dynamic PHP code and static analysis tools
 *
 * Note: This file is part of the development tooling and has no effect on runtime behavior.
 */

namespace PHPSTORM_META;

// Infer the correct type when Envelope::get() is called with a class name
override(Envelope::get(0), type(0));

// Map factory methods to their return types for better autocompletion
override(\Flasher\Prime\FlasherInterface::create(), map(['flasher' => \Flasher\Prime\Factory\FlasherFactory::class, 'theme.' => \Flasher\Prime\Factory\FlasherFactory::class]));
override(\Flasher\Prime\Container\FlasherContainer::create(), map(['flasher' => \Flasher\Prime\Factory\FlasherFactory::class, 'theme.' => \Flasher\Prime\Factory\FlasherFactory::class]));
override(\Flasher\Prime\FlasherInterface::use(), map(['flasher' => \Flasher\Prime\Factory\FlasherFactory::class, 'theme.' => \Flasher\Prime\Factory\FlasherFactory::class]));

// Register and utilize notification type constants for better code completion
registerArgumentsSet('types', 'success', 'error', 'warning', 'info');
expectedArguments(\Flasher\Prime\Notification\NotificationBuilderInterface::type(), 0, argumentsSet('types'));
expectedArguments(\Flasher\Prime\Notification\NotificationBuilderInterface::addFlash(), 0, argumentsSet('types'));
expectedArguments(\Flasher\Prime\Notification\NotificationBuilderInterface::flash(), 0, argumentsSet('types'));
expectedArguments(\Flasher\Prime\Notification\NotificationInterface::setType(), 0, argumentsSet('types'));
expectedArguments(flash(), 1, argumentsSet('types'));
expectedArguments(\Flasher\Prime\flash(), 1, argumentsSet('types'));
expectedReturnValues(\Flasher\Prime\Notification\NotificationInterface::getType(), argumentsSet('types'));

// Define expected arguments for handlers
expectedArguments(\Flasher\Prime\Notification\NotificationBuilderInterface::handler(), 0, 'flasher', 'toastr', 'noty', 'notyf', 'sweetalert');

// Define expected arguments for render formats
expectedArguments(\Flasher\Prime\FlasherInterface::render(), 0, 'html', 'json', 'array');

// Define expected arguments for common option keys
expectedArguments(\Flasher\Prime\Notification\FlasherBuilder::option(), 0, 'timeout', 'timeouts', 'fps', 'position', 'direction', 'rtl', 'style', 'escapeHtml');
