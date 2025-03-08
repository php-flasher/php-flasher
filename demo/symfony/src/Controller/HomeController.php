<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        $themes = [
            // 'flasher',
            // 'amber',
            // 'sapphire',
            // 'crystal',

            // 'emerald',
            // 'ruby',
            // 'onyx',

            'jade',
            //,'aurora',
            // 'neon',
            // 'minimal',

            // 'material',
            // 'google',

            // 'ios',
            // 'slack',
            // 'facebook',
            // 'amazon',
        ];

        $positions = [
            'top-left',
            'top-right',
            'bottom-left',
            'bottom-right',
            'top-center',
            'bottom-center',
            'center-left',
            'center-right',
            'center-center',
        ];

        $messages = [
            'success' => 'Your profile has been updated successfully',
            'info' => 'New: You can now export your reports in PDF format',
            'warning' => 'Your premium subscription will expire in 3 days',
            'error' => 'Payment failed: Your card has been declined',
        ];

        foreach ($themes as $index => $theme) {
            foreach ($messages as $type => $message) {
                $position = $positions[$index % \count($positions)];

                // $message = \sprintf('%s: %s', $theme, $message);

                // flash()
                //     ->use("theme.$theme")
                //     ->option('position', $position)
                //     ->$type($message);
            }
        }

        $plugins = [
            // 'noty',
            // 'notyf',
            // 'sweetalert',
            'toastr',
        ];

        foreach ($plugins as $plugin) {
            foreach ($messages as $type => $message) {
                flash()
                    ->use($plugin)
                    ->$type($message);
            }
        }

        return $this->render('home/index.html.twig');
    }
}
