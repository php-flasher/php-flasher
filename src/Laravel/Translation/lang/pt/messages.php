<?php

declare(strict_types=1);

/**
 * Portuguese translations for PHPFlasher.
 *
 * This file serves as a bridge between Laravel's translation system and
 * PHPFlasher's core translation repository. It simply returns Portuguese
 * translations from the core Messages class.
 *
 * Design pattern: Bridge - Connects Laravel's translation system to PHPFlasher's
 * centralized message store.
 *
 * @return array<string, string> Key-value pairs of message identifiers and translations
 */
return Flasher\Prime\Translation\Messages::get('pt');
