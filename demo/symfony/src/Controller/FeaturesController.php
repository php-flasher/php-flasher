<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class FeaturesController extends AbstractController
{
    #[Route('/features', name: 'app_features')]
    public function index(): Response
    {
        // Demonstrate a few different notification types
        flash()->success('Explore the features of PHPFlasher!');
        flash()->option('timeout', 8000)
               ->info('Click on the links to see each feature in action.');

        return $this->render('features/index.html.twig');
    }

    #[Route('/features/types', name: 'app_types')]
    public function types(): Response
    {
        // Demonstrate different notification types
        flash()->success('This is a success notification!');
        flash()->info('This is an info notification!');
        flash()->warning('This is a warning notification!');
        flash()->error('This is an error notification!');

        return $this->render('features/types.html.twig');
    }

    #[Route('/features/positions', name: 'app_positions')]
    public function positions(): Response
    {
        // Notifications with different positions
        flash()->option('position', 'top-right')->success('This notification appears in the top-right corner!');

        return $this->render('features/positions.html.twig');
    }

    #[Route('/features/options', name: 'app_options')]
    public function options(): Response
    {
        // Notification with custom options
        flash()->option('timeout', 8000)
               ->option('position', 'bottom-center')
               ->option('showProgressbar', true)
               ->success('This notification has custom options!');

        return $this->render('features/options.html.twig');
    }

    #[Route('/features/plugins', name: 'app_plugins')]
    public function plugins(): Response
    {
        // Plugin examples
        flash()->addSuccess('This shows how PHPFlasher can be extended with plugins!');

        return $this->render('features/plugins.html.twig');
    }

    #[Route('/features/presets', name: 'app_presets')]
    public function presets(): Response
    {
        // Example of using presets
        flash()->preset('profile.updated')
               ->success('Your profile has been updated successfully!');

        flash()->preset('item.deleted')
               ->info('The item has been deleted.');

        return $this->render('features/presets.html.twig');
    }
}
