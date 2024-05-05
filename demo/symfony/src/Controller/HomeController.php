<?php

namespace App\Controller;

use App\Entity\Book;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        sweetalert()->timerProgressBar()->success('hello from Home Controller');
        noty()->layout('topCenter')->success('hello from Home Controller');
        notyf()->ripple(false)->warning('hello from Home Controller');
        toastr()->positionClass('toast-bottom-left')->error('hello from Home Controller');
        flash()->use('flasher')->success('hello from flasher factory');

        flash()->created(new Book('lord of the rings'));
        flash()->saved(new Book('harry potter'));

        // flash()->updated();
        // flash()->deleted();

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
}
