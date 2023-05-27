<?php

namespace App\Controller;

use App\Repository\QuestionsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route("/questions")]
class QuestionsController extends AbstractController
{
    #[Route('/')]
    public function index(QuestionsRepository $repository): Response
    {
        return $this->render(
            'questions/index.html.twig',
            ['questions' => $repository->findAll()]
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