<?php

namespace App\Controller;

use App\Repository\AuthorsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route("/authors")]
class AuthorsController extends AbstractController
{
    #[Route('/')]
    public function index(AuthorsRepository $repository): Response
    {
        return $this->render(
            'authors/index.html.twig',
            ['authors' => $repository->findAll()]
        );
    }
}