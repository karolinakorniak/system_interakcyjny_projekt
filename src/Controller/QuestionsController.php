<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Question;
use App\Service\QuestionServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route("/questions")]
class QuestionsController extends AbstractController
{
    /**
     * Question Service
     */
    private QuestionServiceInterface $questionService;

    /**
     * @param QuestionServiceInterface $questionService
     */
    public function __construct(QuestionServiceInterface $questionService)
    {
        $this->questionService = $questionService;
    }


    #[Route('/', name: 'question_index')]
    public function index(Request $request): Response
    {
        $pagination = $this->questionService->getPaginatedList(
            $request->query->getInt('page', 1)
        );

        return $this->render(
            'questions/index.html.twig',
            ['pagination' => $pagination]
        );
    }

    #[Route('/{slug}', name: 'single_question')]
    public function singleQuestion(Question $question): Response
    {
        return $this->render(
            'questions/single.html.twig',
            ['question' => $question]
        );
    }

    #[Route('/byCategory/{slug}', name: "question_by_category")]
    public function byCategory(Request  $request,
                               string   $slug,
                               Category $category): Response
    {
        $pagination = $this->questionService->getPaginatedListByCategory(
            $request->query->getInt('page', 1),
            $slug
        );

        return $this->render(
            'questions/index.html.twig',
            ['pagination' => $pagination, 'category' => $category]
        );

    }
}