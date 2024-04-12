<?php

namespace App\Controller;

use Flasher\Prime\FlasherInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(FlasherInterface $flasher): Response
    {
        $this->addFlash('success', 'welcome from php-flasher');

        flash()->info('hello from Home Controller', ['timeout' => 60000]);
        $flasher->info('hello from Home Controller', ['timeout' => 60000]);

        sweetalert()->success('hello from Home Controller', ['timeout' => 60000]);
        noty()->success('hello from Home Controller', ['timeout' => 60000]);
        notyf()->warning('hello from Home Controller', ['timeout' => 60000]);

        toastr()->error('hello from Home Controller', ['timeout' => 60000]);
        \Flasher\Toastr\Prime\toastr()->error('hello from Home Controller', ['timeout' => 60000]);

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
}
