<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class HomeController.
 */
#[Route("/")]
class HomeController extends AbstractController
{
    /**
     * Index action
     *
     * @return Response HTTP Response
     */
    #[Route('/', name: 'home')]
    public function index(): Response
    {
        return $this->render(
            'home/index.html.twig',
        );
    }

}