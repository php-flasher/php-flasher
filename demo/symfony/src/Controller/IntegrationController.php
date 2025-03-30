<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class IntegrationController extends AbstractController
{
    #[Route('/integration/api', name: 'app_integration_api')]
    public function apiIntegration(): Response
    {
        // Example of how PHPFlasher can work with API responses
        flash()->option('position', 'bottom-center')
               ->success('API request processed successfully!');

        return $this->render('integration/api.html.twig');
    }

    #[Route('/integration/translation', name: 'app_integration_translation')]
    public function translationIntegration(): Response
    {
        // Example using translation integration
        flash()->option('translate', true)
               ->success('messages.success.operation_completed');

        return $this->render('integration/translation.html.twig');
    }

    #[Route('/integration/symfony-flashbag', name: 'app_integration_flashbag')]
    public function symfonyFlashbag(): Response
    {
        // Add message to Symfony flash bag to demonstrate integration
        $this->addFlash('success', 'This message was added using Symfony\'s addFlash method!');
        $this->addFlash('error', 'This error was added using Symfony\'s addFlash method!');
        $this->addFlash('warning', 'This warning was added using Symfony\'s addFlash method!');

        return $this->render('integration/flashbag.html.twig');
    }

    #[Route('/integration/custom-templates', name: 'app_integration_templates')]
    public function customTemplates(): Response
    {
        // Example using custom templates
        flash()->option('template', 'custom_template')
               ->success('This notification uses a custom template!');

        return $this->render('integration/custom-templates.html.twig');
    }
}
