<?php

namespace App\Controller;

use App\Repository\CategoriesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route("/categories")]
class CategoriesController extends AbstractController
{
    #[Route('/')]
    public function index(CategoriesRepository $repository): Response
    {
        return $this->render(
            'categories/index.html.twig',
            ['categories' => $repository->findAll()]
        );
    }
}