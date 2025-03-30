<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ThemesController extends AbstractController
{
    #[Route('/themes', name: 'app_themes')]
    public function index(): Response
    {
        // Show default theme notification
        flash()->success('This is a notification with the default theme!');

        return $this->render('themes/index.html.twig');
    }

    #[Route('/themes/flasher', name: 'app_theme_flasher')]
    public function flasherTheme(): Response
    {
        // Using the Flasher theme
        flash()->option('theme', 'flasher')
               ->success('This notification uses the Flasher theme!');

        return $this->render('themes/flasher.html.twig');
    }

    #[Route('/themes/crystal', name: 'app_theme_crystal')]
    public function crystalTheme(): Response
    {
        // Using the Crystal theme
        flash()->option('theme', 'crystal')
               ->success('This notification uses the Crystal theme!');

        return $this->render('themes/crystal.html.twig');
    }

    #[Route('/themes/emerald', name: 'app_theme_emerald')]
    public function emeraldTheme(): Response
    {
        // Using the Emerald theme
        flash()->option('theme', 'emerald')
               ->success('This notification uses the Emerald theme!');

        return $this->render('themes/emerald.html.twig');
    }

    #[Route('/themes/sapphire', name: 'app_theme_sapphire')]
    public function sapphireTheme(): Response
    {
        // Using the Sapphire theme
        flash()->option('theme', 'sapphire')
               ->success('This notification uses the Sapphire theme!');

        return $this->render('themes/sapphire.html.twig');
    }

    #[Route('/themes/amazon', name: 'app_theme_amazon')]
    public function amazonTheme(): Response
    {
        // Using the Amazon theme
        flash()->option('theme', 'amazon')
               ->success('This notification uses the Amazon theme!');

        return $this->render('themes/amazon.html.twig');
    }
}
