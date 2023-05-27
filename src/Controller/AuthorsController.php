<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AuthorsController extends AbstractController
{
    #[Route('/authors')]
    public function index(): Response
    {
        return $this->render(
            'authors/index.html.twig',
        );
    }
}