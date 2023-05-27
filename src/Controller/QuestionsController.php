<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route("/questions")]
class QuestionsController extends AbstractController
{
    #[Route('/')]
    public function index(): Response
    {
        return $this->render(
            'questions/index.html.twig',
        );
    }

    #[Route('/{slug}')]
    public function singleQuestion(string $slug): Response
    {
        return $this->render(
            'single.html.twig',
            ['slug' => $slug]
        );
    }
}