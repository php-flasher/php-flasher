<?php

declare(strict_types=1);

namespace Flasher\Prime\Response;

use Flasher\Prime\Response\Presenter\ArrayPresenter;
use Flasher\Prime\Response\Presenter\PresenterInterface;

/**
 * ResponseManagerInterface - Contract for response generation and presenter management.
 *
 * This interface defines the essential operations for creating responses with
 * notifications and managing the presenters that render them in different formats.
 * It serves as the main entry point for generating notification responses in
 * specific formats.
 *
 * Design patterns:
 * - Strategy: Manages different presentation strategies through presenters
 * - Factory: Creates responses with specific presenters based on requested format
 *
 * @phpstan-import-type ArrayPresenterType from ArrayPresenter
 */
interface ResponseManagerInterface
{
    /**
     * Renders notifications in a specific format.
     *
     * This method filters notifications based on criteria, removes them from storage,
     * and renders them using the specified presenter. It provides sophisticated return
     * type information for different presenter formats.
     *
     * @param string               $presenter The presenter format to use (e.g., 'html', 'array', 'json')
     * @param array<string, mixed> $criteria  Filtering criteria for selecting notifications
     * @param array<string, mixed> $context   Additional context for the presentation
     *
     * @return mixed The rendered result in the requested format
     *
     * @phpstan-return ($presenter is 'html' ? string :
     *           ($presenter is 'array' ? ArrayPresenterType :
     *           ($presenter is 'json' ? ArrayPresenterType :
     *                       mixed)))
     */
    public function render(string $presenter = 'html', array $criteria = [], array $context = []): mixed;

    /**
     * Registers a presenter with the response manager.
     *
     * This method allows adding custom presenters that can render notifications
     * in different formats. The presenter can be provided either as an instance
     * or as a factory callback.
     *
     * @param string                      $alias     The alias/name for the presenter
     * @param callable|PresenterInterface $presenter The presenter instance or factory
     */
    public function addPresenter(string $alias, callable|PresenterInterface $presenter): void;
}
