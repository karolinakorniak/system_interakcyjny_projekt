<?php

namespace App\Controller;

use App\Repository\QuestionRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route("/questions")]
class QuestionsController extends AbstractController
{
    #[Route('/', name: 'question_index')]
    public function index(Request $request, QuestionRepository $repository, PaginatorInterface $paginator): Response
    {
        $pagination = $paginator->paginate(
            $repository->queryAll(),
            $request->query->getInt('page', 1),
            QuestionRepository::PAGINATOR_ITEMS_PER_PAGE,
        );

        return $this->render(
            'questions/index.html.twig',
            ['pagination' => $pagination]
        );
    }

    #[Route('/{slug}', name: 'single_question')]
    public function singleQuestion(string $slug, QuestionRepository $repository): Response
    {
        $question = $repository->findOneBy(['slug' => $slug]);

        return $this->render(
            'questions/single.html.twig',
            ['question' => $question]
        );
    }
}